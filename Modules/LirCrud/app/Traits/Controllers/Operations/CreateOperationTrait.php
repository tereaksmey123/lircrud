<?php

namespace Modules\LirCrud\app\Traits\Controllers\Operations;

use Modules\BaseApiCore\BaseApiCore;
use Illuminate\Support\Facades\Route;

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
        if ($extraData) {
            // fix sonar bro
        } 

        Route::post($segment.'/', [
            // 'as'        => $segment.'.index',
            'uses'      => $controller.'@'.$operation,
            'operation' => $operation,
        ]);
    }

    protected function setupCreateDefault(): void
    {
        $this->crud->allowAccess('create');
    }

    /**
     * Manipulating Json Response
     *
     * @param Model::create $data
     */
    protected function setupCreateJsonResource($data, array $additional = [])
    {
        return (new ($this->crud->getDefaultJsonResource())($data))->additional(array_merge(
            ['message' => $this->crud->getLanguageOperationSetting($key = 'success_create')
                ?: BaseApiCore::facade()::lang($key)],
            $additional
        ));
    }

    public function create()
    {
        $this->crud->hasAccessOrFail('create');
        
        $this->crud->validateRequest();

        $this->crud->entry = $this->crud->model->create(
            $this->crud->getStrippedSaveRequest()
        );

        return $this->setupCreateJsonResource($this->crud->entry);
    }
}
