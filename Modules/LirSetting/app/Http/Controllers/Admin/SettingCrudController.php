<?php

namespace Modules\LirSetting\app\Http\Controllers\Admin;

use Modules\LirSetting\app\LirSetting;
use Modules\LirCrud\app\Supports\Facades\Crud;
use Modules\LirCrud\app\Supports\CrudPanel\Column;
use Modules\LirCrud\app\Supports\CrudPanel\Components\Columns\Text;
use Modules\LirCrud\app\Supports\CrudPanel\Controllers\CrudController;

class SettingCrudController extends CrudController
{
    use \Modules\LirCrud\app\Traits\Controllers\Operations\ListOperationTrait;
    use \Modules\LirCrud\app\Traits\Controllers\Operations\CreateOperationTrait;

    public function setup()
    {
        Crud::setModel(LirSetting::model());
        Crud::setTitle('Setting', 'Settings');

        // Crud::setResponseSetting(Column::class);
        // Crud::dd();
        
        Column::make('name');
        Column::make('description')->type('Columns.TextArea')->translate();
        Column::make('key')->translate('lircrud::default');
        Column::make('type');
        Column::make('value');
        Column::make('field');
        Column::make('active')->type('Columns.Switch');
        Column::make('active')->type('Columns.Checkbox');
        Column::make('options')->type('Column.Json');
        
        // $this->crud->dd();
    }
}
