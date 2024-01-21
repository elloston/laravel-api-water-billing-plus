<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PumpMeterRecordController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\WaterRateController;

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

// Routes for Bill resource
Route::prefix('bills')->group(function () {
    Route::get('/', [BillController::class, 'index']);
    Route::post('/', [BillController::class, 'store']);
    Route::get('{bill}', [BillController::class, 'show']);
    Route::delete('{bill}', [BillController::class, 'destroy']);
});

// Routes for PumpMeterRecord resource
Route::prefix('pump-meter-records')->group(function () {
    Route::get('/', [PumpMeterRecordController::class, 'index']);
    Route::post('/', [PumpMeterRecordController::class, 'store']);
    Route::get('{pumpMeterRecord}', [PumpMeterRecordController::class, 'show']);
    Route::delete('{pumpMeterRecord}', [PumpMeterRecordController::class, 'destroy']);
});

// Routes for Resident resource
Route::prefix('residents')->group(function () {
    Route::get('/', [ResidentController::class, 'index']);
    Route::post('/', [ResidentController::class, 'store']);
    Route::get('{resident}', [ResidentController::class, 'show']);
    Route::put('{resident}', [ResidentController::class, 'update']);
    Route::delete('{resident}', [ResidentController::class, 'destroy']);
});

// Routes for WaterRate resource
Route::prefix('water-rates')->group(function () {
    Route::get('/', [WaterRateController::class, 'index']);
    Route::post('/', [WaterRateController::class, 'store']);
    Route::get('{waterRate}', [WaterRateController::class, 'show']);
    Route::delete('{waterRate}', [WaterRateController::class, 'destroy']);
});
