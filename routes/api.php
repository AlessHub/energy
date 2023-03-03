<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ConsumptionController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InformsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdviceController;

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

//Admin

Route::middleware(['auth:api', 'isAdmin'])->group(function () {
    Route::post('/logout', [AuthenticateController::class, 'logout']);
    Route::delete('/delete', [AuthenticateController::class, 'destroy']);
    Route::resource('/consumptions', ConsumptionController::class);
    Route::resource('/forums', ForumController::class);
    Route::resource('/comments', CommentController::class);
    Route::resource('/informs', InformsController::class);
    Route::resource('/notifications', NotificationController::class);   
    Route::resource('/advices', AdviceController::class);
});



Route::middleware('auth:api')->group(function(){    
    Route::post('/logout', [AuthenticateController::class, 'logout']);    
    //consumptions -> eliminar, editar, ver, crear
    Route::resource('/consumptions', ConsumptionController::class);
    //forums -> eliminar, editar, ver, crear
    Route::resource('/forums', ForumController::class);
    //comments ->eliminar, editar, ver, crear
    Route::resource('/comments', CommentController::class);
    //informs -> ver
    Route::get('/informs', [InformsController::class, 'index']);
    //notifications -> eliminar y ver
    Route::get('/notifications', [NotificationController::class, 'index']);   
    //advices -> ver
    Route::get('/advices',[AdviceController::class, 'index'] );   
    Route::put('/user/{id}', [AuthenticateController::class, 'update']); 
});


