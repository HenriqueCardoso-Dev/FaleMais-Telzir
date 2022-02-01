<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CallValueCalculator;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('user', [UserController::class, 'store']);
Route::post('tariff', [TariffController::class, 'store']);
Route::post('tariff-remove', [TariffController::class, 'removeTariff']);
Route::post('calculator', [CallValueCalculator::class, 'calculator']);
Route::get('tariffs', [TariffController::class, 'getTariffs']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
