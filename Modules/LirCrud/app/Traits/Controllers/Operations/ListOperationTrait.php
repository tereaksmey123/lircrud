<?php

namespace Modules\LirCrud\app\Traits\Controllers\Operations;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Modules\LirCrud\app\LirCrud;
use Modules\BaseApiCore\BaseApiCore;
use Illuminate\Support\Facades\Route;
use Modules\LirCrud\app\Supports\Facades\Crud;
use Modules\LirCrud\app\Supports\CrudPanel\Column;

trait ListOperationTrait
{
    /**
     * Registe Route
     *
     * @param string $segment
     * @param string $controller
     */
    protected function setupListRoutes($segment, $controller, $extraData)
    {
        $opt = ['operation' => $operation = 'list'];

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
        Crud::allowAccess('list');
        Crud::setResponseSetting(Crud::class);
        Crud::setResponseSetting(Column::class);
        Crud::setOperationSetting('setListPage', 'LirCrud::CrudList');
    }

    public function list()
    {
        return Crud::responsePage(page: Crud::getOperationSetting('setListPage'));
    }

    public function search()
    {
        Crud::hasAccessOrFail('list');

        return Crud::paginate(
             Crud::getOperationSetting('minPerPage'),
             Crud::getOperationSetting('maxPerPage')
        );
    }
}
