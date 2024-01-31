<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Contracts;

use Illuminate\Support\Str;
interface CrudProperty
{
    /**
     * Define key in setting
     *
     * Key must be a plural string, fail convert will result as a bug.
     *
     * @method \Illuminate\Support\Str::plural
     * @method \Illuminate\Support\Str::singular
     * @method \Illuminate\Support\Str::studly
     * @method \Illuminate\Support\Str::camel
     */
    public function propertyKey(): string;
}