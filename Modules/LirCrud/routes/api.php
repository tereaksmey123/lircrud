<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\LirCrud\app\Http\Controllers\Api\LocaleApiController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('lircrud', fn (Request $request) => $request->user())->name('lircrud');
// });

Route::get('locales', [LocaleApiController::class, 'index']);