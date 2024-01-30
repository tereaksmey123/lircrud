<?php

namespace  Modules\LirCrud\app\Supports\CrudPanel\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Modules\LirCrud\app\Supports\Facades\Crud;

class CrudController extends Controller
{
    use \Modules\LirCrud\app\Traits\Controllers\ResponseTrait;
    use \Modules\LirCrud\app\Traits\LoadMethodBySetupPatternTrait;

    public $crud;

    public function __construct()
    {
        if ($this->crud) {
            return;
        }
        
        $this->middleware(function ($request, $next) {
            $this->crud = app(Crud::class);
            $this->setupDefaults();
            $this->setup();
            $this->setupConfigurationForCurrentOperation();

            // if (! $this->crud->getOperationSetting(LirCrud::DISABLE_ENFORCE_RULE_AFTER_OPERATION)) {
            //     $this->enforceRuleAfterOperation()
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
        $this->loadMethodBySetupPattern(
            'setup',
            'Routes',
            fn ($methodName) => $this->{$methodName}($segment, $controller, $extraData),
            $controller
        );
    }

    public function setupDefaults()
    {
        // only run when it has operation name
        if ($operationName = $this->crud->getOperation()) {
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
        $operationName = $this->crud->getOperation();

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
        if (method_exists($this, $setupClassName = 'setup'.Str::studly($operationName).'Operation')) {
            $this->{$setupClassName}();
        }
    }
    
    public function setup()
    {
        // setup
    }
}
