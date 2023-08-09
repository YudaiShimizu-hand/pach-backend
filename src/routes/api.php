<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\PlaceController;
use App\Http\Controllers\v1\ShopController;
use App\Http\Controllers\v1\MachineController;
use App\Http\Controllers\v1\DataController;

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

Route::middleware('verifyFirebaseToken')->prefix('v1')->group(function (){

    //場所情報
    Route::get('/place', [PlaceController::class, 'index']);
    Route::post('/place', [PlaceController::class, 'store']);
    //店舗情報
    Route::get('/shop', [ShopController::class, 'index']);
    Route::post('/shop', [ShopController::class, 'store']);
    //機種情報
    Route::get('/machine', [MachineController::class, 'index']);
    Route::post('/machine', [MachineController::class, 'store']);

    Route::prefix('data')->group(function (){
        Route::post('/store', [DataController::class, 'store']);
    });
});
