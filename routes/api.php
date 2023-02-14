<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ConsumptionController;
use App\Http\Controllers\AuthenticateController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
Route::post('/login', [AuthenticateController::class, 'login']);
Route::resource('/consumptions', ConsumptionController::class);

Route::middleware('auth:api')->group(function(){
    Route::post('/logout', [AuthenticateController::class, 'logout']);
    Route::resource('/forums', ForumController::class);
});