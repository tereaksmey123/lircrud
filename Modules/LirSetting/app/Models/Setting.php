<?php
namespace Modules\LirSetting\app\Models;

use Illuminate\Support\Str;
use Modules\SettingCore\SettingCore;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Modules\LirSetting\app\LirSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    protected static function booted(): void
    {
        parent::boot();

        static::created(function ($setting) {
            $setting->clearCache($setting->type);
        });

        static::updated(function ($setting) {
            $setting->clearCache(
                collect([$setting->getOriginal('type'), $setting->type])
                    ->unique()
                    ->filter()
                    ->toArray()
            );
        });

        static::deleted(function ($setting) {
            $setting->clearCache($setting->type);
        });
        
        // when soft delete is enable, apply below event
        if (method_exists(new self, 'bootSoftDeletes')) {
            static::restored(function ($setting) {
                $setting->clearCache($setting->type);
            });
        

            static::forceDeleted(function ($setting) {
                $setting->clearCache($setting->type);
            });
        }
    }

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'key',
        'name',
        'description',
        'value',
        'field',
        'active',
        'type',
        'validate',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = LirSetting::table();
    }

    /**
     * Get a setting value with cache
     *
     * @param string $key required
     * @param string $type
     */
    public static function get($key, $type = null)
    {
        if (! $type) {
            $type = LirSetting::DEFAULT_TYPE;
        }

        $entry = self::loadSettings($type, $key);

        return $entry ? $entry->CastedValue : '';
    }

    public function clearCache(string|array $types = [])
    {
        if ($types) {
            foreach((array) $types as $type) {
                $type && Cache::forget(LirSetting::prefix().'.'.$type);
            }
        }

        Cache::forget(LirSetting::prefix());
    }

    /**
     * Load setting with cache
     *
     * @param string $type
     * @param string $key
     */
    public static function loadSettings($type = null, $key = null)
    {
        $cache = $type
            ? Cache::remember(
                LirSetting::prefix().'.'.$type,
                now()->addDays(30),
                fn () => self::whereType($type)->get()
            )
            : Cache::remember(
                LirSetting::prefix(),
                now()->addDays(30),
                fn () => self::all()
            );

        if ($key) {
            return $cache->where('key', LirSetting::noPrefix($key))->first();
        }

        return $cache;
    }

    /**
     * Update a setting value
     *
     * @param string $key required
     * @param string $value
     * @param string $type
     */
    public static function set($key, $value = null, $type = null)
    {
        if (! $type) {
            $type = LirSetting::DEFAULT_TYPE;
        }

        $entry = self::where('key', LirSetting::noPrefix($key))->firstOrFail();

        // update the value in the database
        $entry->value = $value;
        $entry->saveOrFail();

        return $entry->CastedValue;
    }

    // public function reEncryptUrl()
    // {
    //     $decrypt =  request()->qpDecrypt(
    //         request()->route(
    //             request()->qpKey()
    //         )
    //     )
        
    //     $noDev = collect(explode('&', $decrypt))->filter(
    //         fn ($v) => ! Str::contains(self::requestForDev(), $v)
    //     )->implode('&')

    //     return (object)[
    //         'special' => request()->qpEncrypt($noDev.'&'.self::requestForDev()),
    //         'default' => request()->qpEncrypt($noDev)
    //     ]
    // }

    // public static function requestForDev(): string
    // {
    //     return SettingCore::REQUEST_FOR_DEV.'=1'
    // }

    // public static function hasSpecialAccess(): bool
    // {
    //     return request()->user()->isDevRole() && request()->{SettingCore::REQUEST_FOR_DEV}
    // }


    protected function castedValue(): Attribute
    {
        return Attribute::make(
            get: fn ($v, $attr) => $attr['value'],
        );
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            set: fn ($v, $attr) => $v
        );
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    // public function getCastedValueAttribute()
    // {
    //     $attr = 'value';

    //     switch (SettingCore::getType($this->validate)) {
    //         case SettingCore::UPLOAD:
    //         case 'fix_sonar_bro':
    //             // $value = $this->myFileExist($this->{$attr}, 'uploads')
    //         break;
    //         default:
    //             $value = $this->{$attr};
    //         break;
    //     }
        
    //     return $value ?? '';
    // }

    /*
    |--------------------------------------------------------------------------
    | MUTATOR
    |--------------------------------------------------------------------------
    */

    // public function setValueAttribute($value)
    // {
    //     $attr = 'value';
        
    //     switch (SettingCore::getType($this->validate)) {
    //         case SettingCore::UPLOAD:
    //         case 'fix_sonar_bro':
    //             // if (request()->has('fsc_prevent_upload_mutator')) {
    //             //     $this->attributes[$attr] = str_replace(Str::fscAwsOnlyDomain(), '', $value)
    //             // } else {
    //             //     $this->myCrudUpload($value, $attr, $diskPath)
    //             // }
    //         break;
    //         default:
    //             $this->attributes[$attr] = $value;
    //         break;
    //     }
    // }
}
