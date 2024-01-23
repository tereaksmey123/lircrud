<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Traits;

/**
 * Key-value store for operations.
 */
trait SettingTrait
{
    // use \Modules\BaseApiCore\Supports\CrudPanel\Traits\SettingTrait\LanguageSettingTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Traits\SettingTrait\DefaultSettingTrait;

    /**
     * @var array
     */
    protected $settings = [];
    
    public function get(string $key)
    {
        return $this->settings[$key] ?? null;
    }
    
    public function set(string $key, $value)
    {
        return $this->settings[$key] = $value;
    }
    
    public function has(string $key): bool
    {
        if (isset($this->settings[$key])) {
            return true;
        }

        return false;
    }
    
    public function getOperationSetting(string $key, $operation = null)
    {
        $operation = $operation ?? $this->getCurrentOperation();

        return $this->get($operation.'.'.$key) ?? null;
    }
    
    public function hasOperationSetting(string $key, $operation = null)
    {
        $operation = $operation ?? $this->getCurrentOperation();

        return $this->has($operation.'.'.$key);
    }
    
    public function setOperationSetting(string $key, $value, $operation = null)
    {
        $operation = $operation ?? $this->getCurrentOperation();

        return $this->set($operation.'.'.$key, $value);
    }
    
    public function loadDefaultOperationSettingsFromConfig($configPath = null): void
    {
        $operation = $this->getCurrentOperation();
        $configPath = $configPath ?? 'lircrud.operations.'.$operation;
        $configSettings = config($configPath);

        if (is_array($configSettings) && count($configSettings)) {
            foreach ($configSettings as $key => $value) {
                $this->setOperationSetting($key, $value);
            }
        }
    }
}
