<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\PlaceController;
use App\Http\Controllers\v1\ShopController;

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
    Route::post('/place', [PlaceController::class, 'store']);
    Route::post('/shop', [ShopController::class, 'store']);
});
