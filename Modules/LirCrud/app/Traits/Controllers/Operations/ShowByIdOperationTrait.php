<?php

namespace Modules\LirCrud\app\Traits\Controllers\Operations;

use Modules\BaseApiCore\BaseApiCore;
use Illuminate\Support\Facades\Route;

trait ShowByIdOperationTrait
{
    /**
     * Registe Route
     *
     * @param string $segment
     * @param string $controller
     */
    protected function setupShowByIdRoutes($segment, $controller, $extraData, $operation = 'showById'): void
    {
        if ($extraData) {
            // fix sonar bro
        } 

        Route::get($segment.'/{id}', [
            // 'as'        => $segment.'.index',
            'uses'      => $controller.'@'.$operation,
            'operation' => $operation,
        ])->whereNumber('id');
    }

    protected function setupShowByIdDefault(): void
    {
        $this->crud->allowAccess('showById');
    }

    /**
     * Manipulating Json Response
     *
     * @param Model::find $data
     */
    protected function setupShowByIdJsonResource($data, array $additional = [])
    {
        return (new ($this->crud->getDefaultJsonResource())($data))->additional(array_merge(
            ['message' => $this->crud->getLanguageOperationSetting($key = 'success_retrieve')
                ?: BaseApiCore::facade()::lang($key)],
            $additional
        ));
    }

    public function showById()
    {
        $this->crud->hasAccessOrFail('showById');

        if (! $find = $this->crud->query->find(request()->route('id'))) {
            return $this->responseFail(
                $this->crud->getLanguageOperationSetting($key = 'not_found')
                    ?: BaseApiCore::facade()::lang($key),
                404
            );
        }

        return $this->setupShowByIdJsonResource($find);
    }
}
