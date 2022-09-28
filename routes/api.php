<?php

use App\Http\Controllers\Api\Auth\GuardController;
use App\Http\Controllers\Api\Finance\LedgerController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function() {
    Route::prefix('auth')->controller(GuardController::class)->group(function() {
        Route::post('/login', 'login');
    });
    Route::prefix('ledger')->controller(LedgerController::class)->group(function() {
        Route::get('/', 'index');
        Route::get('/{ledger}', 'show')->where('ledger', '[0-9]+');
        Route::post('/', 'store');
        Route::put('/{ledger}', 'update')->where('ledger', '[0-9]+');
        Route::delete('/{ledger}', 'destroy')->where('ledger', '[0-9]+');
    });
});
