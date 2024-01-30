<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Traits;

trait SettingTrait
{
    protected array $settings = [];
    
    /**
     * Get setting
     */
    public function get(string $key)
    {
        return $this->settings[$key] ?? null;
    }
    
    /**
     * Set setting
     *
     * Prevent public access as it might lead to corrupted data.
     * only allow within internal CRUD API itself
     * IF NEED: You must introduce a new method throught macro to CRUD API
     */
    protected function set(string $key, $value)
    {
        return $this->settings[$key] = $value;
    }
    
    /**
     * Check setting key exists
     */
    public function has(string $key): bool
    {
        return isset($this->settings[$key]);
    }
    
    /**
     * Get setting from operation
     */
    public function getOperationSetting(string $key)
    {
        return $this->get($this->getOperation().'.'.$key) ?? null;
    }

    /**
     * Check setting exists from operation
     */
    public function hasOperationSetting(string $key): bool
    {
        return $this->has($this->getOperation().'.'.$key);
    }

    /**
     * Set setting from operation
     */
    public function setOperationSetting(string $key, $value)
    {
        return $this->set($this->getOperation().'.'.$key, $value);
    }
}
