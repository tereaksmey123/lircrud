<?php

namespace Modules\LirSetting\app\Http\Controllers\Admin;

use Modules\LirSetting\app\LirSetting;
use Modules\LirCrud\app\Supports\Facades\Crud;
use Modules\LirCrud\app\Supports\CrudPanel\Controllers\CrudController;

class SettingCrudController extends CrudController
{
    use \Modules\LirCrud\app\Traits\Controllers\Operations\ListOperationTrait;
    use \Modules\LirCrud\app\Traits\Controllers\Operations\CreateOperationTrait;

    public function setup()
    {
        Crud::setModel(LirSetting::model());
        Crud::setTitle('Setting', 'Settings');
    }
}
