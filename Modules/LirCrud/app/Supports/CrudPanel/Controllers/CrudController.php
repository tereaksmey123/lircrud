<?php

namespace  Modules\LirCrud\app\Supports\CrudPanel\Controllers;

use Illuminate\Support\Str;
use Modules\LirCrud\LirCrud;
use App\Http\Controllers\Controller;

class CrudController extends Controller
{
    // use \Modules\LirCrud\app\Traits\Controllers\SetupRouteTrait;
    // use \Modules\LirCrud\app\Traits\Controllers\SetupDefaultTrait;
    // use \Modules\LirCrud\app\Traits\Controllers\SetupOperationTrait;
    use \Modules\LirCrud\app\Traits\Controllers\ResponseTrait;
    use \Modules\LirCrud\app\Traits\LoadMethodBySetupPatternTrait;

    public $crud;

    public function __construct()
    {
        if ($this->crud) {
            return;
        }
        
        $this->middleware(function ($request, $next) {
            $this->crud = LirCrud::getCrudPanel();
            $this->setupDefaults();
            $this->setup();
            $this->setupConfigurationForCurrentOperation();

            // if (! $this->crud->getOperationSetting(LirCrud::DISABLE_ENFORCE_RULE_AFTER_OPERATION)) {
            //     $this->enforceRuleAfterOperation();
            // }

            return $next($request);
        });
    }
    
    /**
     * setupRoutes
     *
     * @param string $segment
     * @param string $controller
     * @param array $extraData
     */
    public function setupRoutes($segment, $controller, $extraData): void
    {
        $this->loadMethodBySetupPatternClass = $controller;

        $this->loadMethodBySetupPattern('setup', 'Routes', function ($methodName) use ($segment, $controller, $extraData) {
            $this->{$methodName}($segment, $controller, $extraData);
        });
    }

    public function setupDefaults(): void
    {
        // only run when it has operation name
        if ($operationName = $this->crud->getCurrentOperation()) {
            $method = 'setup'.Str::studly($operationName).'Default';

            if (method_exists($this, $method)) {
                $this->{$method}();
            }
        }
    }

    /**
     * Load configurations for the current operation.
     *
     * Allow developers to insert default settings by creating a method
     * that looks like setupOperationNameOperation (aka setupXxxOperation).
     */
    protected function setupConfigurationForCurrentOperation()
    {
        $operationName = $this->crud->getCurrentOperation();
        $setupClassName = 'setup'.Str::studly($operationName).'Operation';

        /*
         * FIRST, run all Operation Closures for this operation.
         *
         * It's preferred for this to closures first, because
         * (1) setup() is usually higher in a controller than any other method, so it's more intuitive,
         * since the first thing you write is the first thing that is being run;
         * (2) operations use operation closures themselves, inside their setupXxxDefaults(), and
         * you'd like the defaults to be applied before anything you write. That way, anything you
         * write is done after the default, so you can remove default settings, etc;
         */
        $this->crud->applyConfigurationFromSettings($operationName);

        /*
         * THEN, run the corresponding setupXxxOperation if it exists.
         */
        if (method_exists($this, $setupClassName)) {
            $this->{$setupClassName}();
        }
    }

    // protected function enforceRuleAfterOperation()
    // {
    //     $this->crud->addClause(LirCrud::enforceRuleAfterOperationModelScope());
    // }

    // protected function disableEnforceRuleAfterOperation()
    // {
    //     $this->crud->setOperationSetting(LirCrud::DISABLE_ENFORCE_RULE_AFTER_OPERATION, true);
    // }
    
    public function setup()
    {
        // setup
    }
}
