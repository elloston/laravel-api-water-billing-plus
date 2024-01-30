<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PumpMeterRecordController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\WaterRateController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(BillController::class)->prefix('bills')->group(function () {
        Route::post('/', 'store');
        Route::get('{bill}', 'show');
        Route::delete('{bill}', 'destroy');
    });

    Route::controller(PumpMeterRecordController::class)->prefix('pump-meter-records')->group(function () {
        Route::post('/', 'store');
        Route::get('{pumpMeterRecord}', 'show');
        Route::delete('{pumpMeterRecord}', 'destroy');
    });

    Route::controller(ResidentController::class)->prefix('residents')->group(function () {
        Route::post('/', 'store');
        Route::get('{resident}', 'show');
        Route::put('{resident}', 'update');
        Route::delete('{resident}', 'destroy');
    });

    Route::controller(WaterRateController::class)->prefix('water-rates')->group(function () {
        Route::post('/', 'store');
        Route::get('{waterRate}', 'show');
        Route::delete('{waterRate}', 'destroy');
    });
});

Route::get('/bills', [BillController::class, 'index']);
Route::get('/pump-meter-records', [PumpMeterRecordController::class, 'index']);
Route::get('/residents', [ResidentController::class, 'index']);
Route::get('/water-rates', [WaterRateController::class, 'index']);
