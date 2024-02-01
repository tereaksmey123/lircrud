<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Crud;

use Illuminate\Support\Facades\Route;
use Modules\LirCrud\app\Supports\Enum\CrudEnum;

trait OperationTrait
{
    /**
     * Operation define by controller
     */
    protected ?string $operation;
    
    public function getOperation(): string
    {
        return $this->operation
            ?? Route::getCurrentRoute()->action[CrudEnum::OPERATION->value]
            ?? null;
    }

    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }

    /**
     * Store a closure which configure to a certain operation inside settings.
     * apply when call @method self applyConfigurationFromSettings
     */
    public function operation(string|array $operations, bool|\Closure $closure = false): void
    {
        foreach ((array) $operations as $operation) {
            $configuration = (array) $this->get($operation.'.'.CrudEnum::CONFIGURATION->value);
            $configuration[] = $closure;

            $this->set($operation.'.'.CrudEnum::CONFIGURATION->value, $configuration);
        }
    }

    public function applyConfigurationFromSettings(string|array $operations): void
    {
        foreach ((array) $operations as $operation) {
            $configuration = (array) $this->get($operation.'.'.CrudEnum::CONFIGURATION->value);

            if (count($configuration)) {
                foreach ($configuration as $closure) {
                    if (is_callable($closure)) {
                        ($closure)();
                    }
                }
            }
        }
    }
}
