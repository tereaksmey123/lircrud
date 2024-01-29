<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Traits;

trait SettingTrait
{
    protected array $settings = [];
    
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
    
    /**
     * Get setting, base on given operation or current operation
     */
    public function getOperationSetting(string $key, ?string $operation = null)
    {
        $operation = $operation ?? $this->getCurrentOperation();

        return $this->get($operation.'.'.$key) ?? null;
    }

    /**
     * Check setting exists, base on given operation or current operation
     */
    public function hasOperationSetting(string $key, ?string $operation = null): bool
    {
        $operation = $operation ?? $this->getCurrentOperation();

        return $this->has($operation.'.'.$key);
    }

    /**
     * Set setting, base on given operation or current operation
     */
    public function setOperationSetting(string $key, $value, ?string $operation = null)
    {
        $operation = $operation ?? $this->getCurrentOperation();

        return $this->set($operation.'.'.$key, $value);
    }
}
