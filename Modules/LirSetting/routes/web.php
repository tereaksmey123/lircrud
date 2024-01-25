<?php

use Illuminate\Support\Facades\Route;
use Modules\LirSetting\app\Http\Controllers\Admin\SettingCrudController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
if (config('lirsetting.crud_ui_enable')) {
    Route::group([
        'prefix' => 'admin',
        'middleware' => ['web', 'auth']
    ], function () {
        Route::lircrud('setting', SettingCrudController::class);
    });
}
