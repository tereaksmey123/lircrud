<?php

namespace Modules\LirSetting\app\Facades;

use Illuminate\Support\Facades\Facade;


class Setting extends Facade
{
    /**
     * @method static get(string $key, $type = null)
     * @method static set(string $key, $value = null)
     * @method static loadSettings($type = null, $key = null)
     */
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Setting::class;
    }
}
