<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Abstracts;

use Modules\LirCrud\app\Supports\Facades\Crud;
use Modules\LirCrud\app\Supports\Enum\PropertyEnum;

abstract class CrudProperty
{
   
    protected ?string $name;

    /**
     * Define key in setting
     *
     * Key must be a plural string, fail convert will result as a bug.
     * * \Illuminate\Support\Str::plural
     * * \Illuminate\Support\Str::singular
     * * \Illuminate\Support\Str::studly
     * * \Illuminate\Support\Str::camel
     */
    protected string $key;


    /**
     * ------------
     * Property API
     * ------------
     */

    protected function property(): array
    {
        return $this->properties()[$this->name] ?? [];
    }

    protected function properties(): array
    {
        return Crud::properties($this->key);
    }

    protected function getPropertyNames(bool|callable $filter = false, array $pluck = []): array
    {
        return Crud::getPropertyNames($this->key, $filter, $pluck);
    }

    protected function addProperty(array $property): static
    {
        Crud::addProperty($this->key, $property);

        return $this;
    }
    
    protected function addProperties(array $properties): static
    {
        Crud::addProperties($this->key, $properties);

        return $this;
    }
    
    protected function removeProperty(string $name): static
    {
        Crud::removeProperty($this->key, $name);

        return $this;
    }
    
    protected function removeProperties(array $names): static
    {
        Crud::removeProperties($this->key, $names);

        return $this;
    }

    protected function modifyProperty(array $data): static
    {
        Crud::modifyProperty($this->key, $this->name, $data);

        return $this;
    }

    /**
     * --------------------
     * General API
     * --------------------
     */

    public function label(string $value): static
    {
        $this->modifyProperty([PropertyEnum::LABEL->value => $value]);

        return $this;
    }

    public function type(string $value): static
    {
        $this->modifyProperty([PropertyEnum::TYPE->value => $value]);

        return $this;
    }

    public function translate(string $value = 'default')
    {
        $this->modifyProperty([PropertyEnum::TRANSLATE->value => $value]);
    }
}