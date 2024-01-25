<?php

namespace Modules\LirSetting\app;

use Modules\LirSetting\app\Models\Setting;
use Modules\LirSetting\app\Http\Controllers\Admin\SettingCrudController;


class LirSetting
{
    /**
     * Module name for view, config, lang
     *
     * @var string MNAME
     */
    const MNAME = 'lirsetting';

    /**
     * Module name with prefix :: for view, config, lang
     *
     * @var string MNAME
     */
    const MNAME_SYMBOL = self::MNAME.'::';

    /**
     * Default type in database
     *
     * @var string DEFAULT_TYPE
     */
    const DEFAULT_TYPE = 'DEFAULT';

    public static function table()
    {
        return config('lirsetting.table') ?: 'settings';
    }

    /**
     * String prefix - use in cache name
     */
    public static function prefix(): string
    {
        return config('lirsetting.prefix') ?: 'settings';
    }

    /**
     * Remove prefix
     *
     * @param string $key
     */
    public static function noPrefix($key): ?string
    {
        return str_replace(self::prefix().'.', '', $key);
    }

    /**
     * Set model class
     */
    public static function model(): string
    {
        return config('lirsetting.model') ?: Setting::class;
    }

    /**
     * Set Controller class
     */
    public static function controller(): string
    {
        return config('lirsetting.controller') ?: SettingCrudController::class;
    }
}
