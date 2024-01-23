<?php

namespace Modules\LirCrud\app\Traits\Controllers\Operations;

use Illuminate\Support\Facades\Route;
use Modules\LirCrud\app\Supports\Facades\Crud;

trait CreateOperationTrait
{
    /**
     * Registe Route
     *
     * @param string $segment
     * @param string $controller
     */
    protected function setupCreateRoutes($segment, $controller, $extraData, $operation = 'create')
    {
        if (isset($extraData['create'])) {
            // fix sonar bro
        }

        Route::get($segment.'/create', [
            'uses' => $controller.'@'.$operation,
            'operation' => $operation,
        ]);

        Route::post($segment.'/store', [
            'uses' => $controller.'@store',
            'operation' => $operation,
        ]);
    }

    protected function setupCreateDefault(): void
    {
        $this->crud->allowAccess('create');
    }

    public function create()
    {
        Crud::hasAccessToAny(['a']);
        Crud::hasAccessOrFail('create1');

        return inertia('LirCrud::CrudCreate');
        
        // $this->crud->validateRequest();

        // $this->crud->entry = $this->crud->model->create(
        //     $this->crud->getStrippedSaveRequest()
        // );

        // return $this->setupCreateJsonResource($this->crud->entry);
    }

    public function store()
    {
        
    }
}
