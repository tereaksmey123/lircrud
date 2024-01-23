<?php

namespace Modules\LirCrud\app\Supports\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static void setModel(string $modelNamespace)
 */
class Crud extends Facade
{
    // /**
    //  * @method static setModel(string $modelNamespace)
    //  * @method static set(string $key, $value = null)
    //  */
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Crud::class;
    }
}
