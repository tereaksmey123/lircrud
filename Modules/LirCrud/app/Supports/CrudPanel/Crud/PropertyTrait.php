<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Crud;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\LirCrud\app\Supports\Enum\PropertyEnum;

trait PropertyTrait
{
    private function toSingular(string $key): string
    {
        return Str::singular($key);
    }

    private function toSingularStudly(string $key): string
    {
        return Str::studly($this->toSingular($key));
    }

    private function toPlural(string $key): string
    {
        return Str::plural($key);
    }

    private function toPluralStudly(string $key): string
    {
        return Str::studly($this->toPlural($key));
    }

    private function toPluralCamel(string $key): string
    {
        return Str::camel($this->toPlural($key));
    }

    /**
     * Key must be provide as plural string word
     */
    private function propertyKey(string $key): string
    {
        return $this->toPluralCamel($key);
    }

    /**
     * Get properties from setting
     */
    public function properties(string $key): array
    {
        return $this->getOperationSetting($this->propertyKey($key)) ?? [];
    }

    /**
     * Get property from setting
     */
    public function property(string $key, string $name)
    {
        return $this->properties($key)[$name] ?? [];
    }

    /**
     * Set/override property into setting
     */
    private function transformProperty(string $key, callable $callback): void
    {
        $this->setOperationSetting(
            $this->propertyKey($key),
            $callback($this->properties($key))
        );
    }

    /**
     * Add property to setting
     *
     * Gurantee correct key order base on code execute order
     */
    public function addProperty(string $key, array $property): void
    {
        // Need to remove the property before add property
        // To make sure item is push into correct order
        // Base on developer code execute order
        $this->removeProperty($key, $property[PropertyEnum::KEY->value]);

        // change from Arr::add() into Arr::set()
        $this->transformProperty($key, fn ($properties) => Arr::set(
            $properties,
            $property[PropertyEnum::KEY->value],
            $property
        ));
    }
    
    /**
     * Remove property from setting
     */
    public function removeProperty(string $key, string $name): void
    {
        $this->transformProperty($key, function ($properties) use ($name) {
            Arr::forget($properties, $name);

            return $properties;
        });
        // $this->transformProperty($key, function ($datas) use ($name) {
        //     Arr::forget($datas, $name);

        //     return $datas;
        // })
    }
    
    /**
     * Add multiple property to setting
     */
    public function addProperties(string $key, array $properties): void
    {
        foreach ($properties as $property) {
            $this->addProperty($key, $property);
        }
    }
    
    /**
     * Remove mulitple property from setting
     */
    public function removeProperties(string $key, array $names): void
    {
        foreach ($names as $name) {
            $this->removeProperty($key, $name);
        }
    }

    /**
     * Modify property / Add property in setting
     *
     * * When $name exists, Only override given key & value
     * * When $name not exists, Create new key, can be consider as addProperty
     * * * But difference order from addProperty, it won't follow code execute order
     */
    public function modifyProperty(string $key, string $name, array $modifyData): void
    {
        $this->transformProperty(
            $key,
            fn ($properties) => Arr::set(
                $properties,
                $name,
                [...($properties[$name] ?? []), ...$modifyData] // to reassure other field is not touched
            )
        );
    }

    /**
     * Get registered properties
     *
     * * By default get a list of [PropertyEnum::KEY->value] in properties
     * * Result will be vary base on $filter & $pluck
     * * * [value, ...]
     * * * [key<pluck[1]> => value<pluck[0]>]
     */
    public function getPropertyNames(string $key, bool|callable $filter = false, array $pluck = []): array
    {
        $properties = $this->properties($key);

        if (is_callable($filter)) {
            $properties = Arr::where($properties, function ($value) use ($filter) {
                return $filter($value);
            });
        }
        
        if (count($pluck)) {
            return Arr::pluck($properties, ...$pluck);
        }

        return Arr::flatten(Arr::pluck($properties, PropertyEnum::KEY->value));
    }
}
