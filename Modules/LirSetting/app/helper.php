<?php

use Modules\LirSetting\app\Facades\Setting;

if (! function_exists('setting')) {
    /**
     * Setting Get & Set, with cache
     *
     * setting('key') - Setting::get($key)
     *
     * setting('key', 'type') - Setting::get($key, $type)
     *
     * setting('key', 'type', 'value') - Setting::set($key, $value, $type)
     *
     * @param string $key required
     * @param null|string $type
     * @param null|mixed $value
     */
    function setting($key, $type = null, $value = null)
    {
        // when not null then set the value
        if ($value !== null) {
            return Setting::set($key, $value, $type);
        }

        if ($type !== null) {
            return Setting::get($key, $type);
        }

        return Setting::get($key);
    }
}

if (! function_exists('settings')) {
    /**
     * Setting load all|by type, with cache
     *
     * settings() - Setting::loadSettings()
     *
     * settings('type') - Setting::loadSettings($type)
     *
     * @param string $key required
     * @param null|string $type
     * @param null|mixed $value
     */
    function settings($type = null)
    {
        return Setting::loadSettings($type);
    }
}
