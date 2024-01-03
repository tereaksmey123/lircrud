<?php

use Illuminate\Support\Facades\Route;
use Modules\LirCrud\app\Http\Controllers\Auth\LoginController;
use Modules\LirCrud\app\Http\Controllers\Admin\DashboardController;

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

Route::group([
    'prefix' => 'admin'
], function () {
    Route::middleware('guest')->get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
    Route::delete('logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth']
], function () {
    Route::redirect('/', 'admin/dashboard');
    Route::get('dashboard', DashboardController::class);
});
