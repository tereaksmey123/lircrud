<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Traits;

use Illuminate\Support\Facades\Route;

trait OperationTrait
{
    /*
    |--------------------------------------------------------------------------
    |                               OPERATIONS
    |--------------------------------------------------------------------------
    | Helps developers set and get the current CRUD operation, as defined by
    | the contoller method being run.
    */
    protected $currentOperation;

    /**
     * Get the current CRUD operation being performed.
     *
     * @return string Operation being performed in string form.
     */
    public function getOperation()
    {
        return $this->getCurrentOperation();
    }

    /**
     * Set the CRUD operation being performed in string form.
     *
     * @param  string  $operation_name  Ex: create / update / revision / delete
     */
    public function setOperation($operation_name)
    {
        $this->setCurrentOperation($operation_name);
    }

    /**
     * Get the current CRUD operation being performed.
     *
     * @return string Operation being performed in string form.
     */
    public function getCurrentOperation()
    {
        return $this->currentOperation ?? Route::getCurrentRoute()->action['operation'] ?? null;
    }

    /**
     * Set the CRUD operation being performed in string form.
     *
     * @param  string  $operation_name  Ex: create / update / revision / delete
     */
    public function setCurrentOperation($operation_name)
    {
        $this->currentOperation = $operation_name;
    }

    /**
     * Convenience method to make sure all calls are made to a particular operation.
     *
     * @param  string|array  $operation  Operation name in string form
     * @param  bool|\Closure  $closure  Code that calls CrudPanel methods.
     * @return void
     */
    public function operation($operations, $closure = false)
    {
        $this->configureOperation($operations, $closure);
    }

    /**
     * Store a closure which configures a certain operation inside settings.
     * Allc configurations are put inside that operation's namespace.
     * Ex: show.configuration.
     *
     * @param  string|array  $operation  Operation name in string form
     * @param  bool|\Closure  $closure  Code that calls CrudPanel methods.
     * @return void
     */
    public function configureOperation($operations, $closure = false)
    {
        $operations = (array) $operations;

        foreach ($operations as $operation) {
            $str = 'configuration';
            $configuration = (array) $this->get($operation.'.'.$str);
            $configuration[] = $closure;

            $this->set($operation.'.'.$str, $configuration);
        }
    }

    /**
     * Run the closures that have been specified for each operation, as configurations.
     * This is called when an operation does setCurrentOperation().
     *
     *
     * @param  string|array  $operations  [description]
     * @return void
     */
    public function applyConfigurationFromSettings($operations)
    {
        $operations = (array) $operations;

        foreach ($operations as $operation) {
            $configuration = (array) $this->get($operation.'.configuration');

            if (count($configuration)) {
                foreach ($configuration as $closure) {
                    if (is_callable($closure)) {
                        // apply the closure
                        ($closure)();
                    }
                }
            }
        }
    }
}
