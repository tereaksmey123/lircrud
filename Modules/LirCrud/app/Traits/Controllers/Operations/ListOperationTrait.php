<?php

namespace Modules\LirCrud\app\Traits\Controllers\Operations;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Modules\LirCrud\app\LirCrud;
use Modules\BaseApiCore\BaseApiCore;
use Illuminate\Support\Facades\Route;

trait ListOperationTrait
{
    /**
     * Registe Route
     *
     * @param string $segment
     * @param string $controller
     */
    protected function setupListRoutes($segment, $controller, $extraData, $operation = 'list')
    {
        $opt = ['operation' => $operation];

        Route::get($segment.'/', [
            'uses' => $controller.'@'.$operation,
            ...$opt
        ]);
        Route::post($segment.'/search',  [
            'uses' => $controller.'@search',
            ...$opt
        ]);
    }

    protected function setupListDefault()
    {
        $this->crud->allowAccess('list');
    }

    /**
     * Manipulating Json Response
     *
     * @param Model::paginate $data
     */
    protected function setupListJsonResource($data, array $additional = [])
    {
        // Manipulate new field to $data
        // $data->map(function ($v) {
        //     $v->ddd = $v->contact;
        //     return $v;
        // })
        
        return $this->crud->getDefaultJsonResource()::collection($data)->additional(array_merge(
            ['message' => $this->crud->getLanguageOperationSetting($key = 'success_retrieve')
                ?: LirCrud::lang($key)],
            $additional
        ));
    }

    public function list()
    {
        return inertia('LirCrud::CrudList', [
            ...$this->crud->inertiaShare()
        ]);
    }

    public function search()
    {
        $this->crud->hasAccessOrFail('list');

        return $this->crud->paginate(
            $this->crud->getOperationSetting('minPerPage'),
            $this->crud->getOperationSetting('maxPerPage')
        );
        
        // $this->crud->applySearchTerm();

        // return $this->setupListJsonResource(
            return request()->has('limit') || request()->has('offset')
                ? $this->crud->skipTakeGet(
                    $this->crud->getOperationSetting('offset'),
                    $this->crud->getOperationSetting('limit')
                )
                : $this->crud->paginate(
                    $this->crud->getOperationSetting('minPerPage'),
                    $this->crud->getOperationSetting('maxPerPage')
                );
        // );
    }
}
