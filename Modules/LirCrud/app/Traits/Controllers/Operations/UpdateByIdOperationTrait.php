<?php

namespace Modules\LirCrud\app\Traits\Controllers\Operations;

use Modules\BaseApiCore\BaseApiCore;
use Illuminate\Support\Facades\Route;

trait UpdateByIdOperationTrait
{
    /**
     * Registe Route
     *
     * @param string $segment
     * @param string $controller
     */
    protected function setupUpdateByIdRoutes($segment, $controller, $extraData, $operation = 'updateById')
    {
        if ($extraData) {
            // fix sonar bro
        } 

        Route::put($segment.'/{id}', [
            // 'as'        => $segment.'.index',
            'uses'      => $controller.'@'.$operation,
            'operation' => $operation,
        ]);
    }

    protected function setupUpdateByIdDefault(): void
    {
        $this->crud->allowAccess('updateById');
    }

    /**
     * Manipulating Json Response
     *
     * @param Model::create $data
     */
    protected function setupUpdateByIdJsonResource($data, array $additional = [])
    {
        return (new ($this->crud->getDefaultJsonResource())($data))->additional(array_merge(
            ['message' => $this->crud->getLanguageOperationSetting($key = 'success_update')
                ?: BaseApiCore::facade()::lang($key)],
            $additional
        ));
    }

    public function updateById()
    {
        $this->crud->hasAccessOrFail('updateById');
        
        $this->crud->validateRequest();

        if (! $find = $this->crud->query->find(request()->route('id'))) {
            return $this->responseFail(
                $this->crud->getLanguageOperationSetting($key = 'not_found')
                    ?: BaseApiCore::facade()::lang($key),
                404
            );
        }

        $find->update($this->crud->getStrippedSaveRequest());

        $this->crud->entry = $find;
        
        return $this->setupUpdateByIdJsonResource($this->crud->entry);
    }
}
