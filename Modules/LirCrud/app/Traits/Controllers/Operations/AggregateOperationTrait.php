<?php

namespace Modules\LirCrud\app\Traits\Controllers\Operations;

use Illuminate\Support\Str;
use Modules\BaseApiCore\BaseApiCore;
use Illuminate\Support\Facades\Route;

trait AggregateOperationTrait
{
    /**
     * Registe Route
     *
     * @param string $segment
     * @param string $controller
     */
    protected function setupAggregateRoutes($segment, $controller, $extraData, $operation = 'aggregate')
    {
        $routeArray = [
            // 'as' => $segment.'.index',
            'uses' => $controller.'@'.$operation,
            'operation' => $operation,
        ];

        if (Str::lower($extraData[$operation]['route_method'] ?? '') == 'post') {
            Route::post($segment.'/aggregate', $routeArray);
        } else {
            Route::get($segment.'/aggregate', $routeArray);
        }
    }

    protected function setupAggregateDefault()
    {
        $this->crud->allowAccess('aggregate');

        $this->crud->setValidation(\Modules\BaseApiCore\Http\Requests\AggregateRequest::class);

        $this->crud->disableAutoFieldOnReponseFromRequest();
    }

    /**
     * Manipulating Json Response
     *
     * @param Model::paginate $data
     */
    protected function setupAggregateJsonResource($data, array $additional = [])
    {
        // Manipulate new field to $data
        // $data->map(function ($v) {
        //     $v->ddd = $v->contact;
        //     return $v;
        // })
        
        return $this->crud->getDefaultJsonResource()::collection($data)->additional(array_merge(
            ['message' => $this->crud->getLanguageOperationSetting($key = 'success_retrieve')
                ?: BaseApiCore::facade()::lang($key)],
            $additional
        ));
    }

    public function aggregate()
    {
        $this->crud->hasAccessOrFail('aggregate');
        
        $this->crud->validateRequest();

        $this->crud->applySearchTerm();

        $query = $this->crud->query;

        $field = request()->field;

        $onAggregate = $this->crud->getFieldNames(
            fn ($v) => is_callable($v['onAggregate']),
            ['onAggregate', 'name']
        );

        $onAggregate = $onAggregate[$field]($field)[request()->function] ?? false;
        
        $select = collect([
            request()->has('groupBy') ? request()->groupBy : '',
            $onAggregate ? $onAggregate($field) : ''
        ])->filter()->toArray();
        
        $query->select($select);
        
        if (request()->has('groupBy') && $groupBy = request()->groupBy) {
            $query->groupBy($groupBy);
        }
        
        return $this->setupAggregateJsonResource($query->get());
    }
}
