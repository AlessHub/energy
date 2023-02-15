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

// Route::middleware('auth:api')->group(function(){    
//     Route::post('/logout', [AuthenticateController::class, 'logout']);
//     Route::resource('/consumptions', ConsumptionController::class);
//     Route::resource('/forums', ForumController::class);
//     Route::resource('/comments', CommentController::class);
//     Route::resource('/informs', InformsController::class);
//     Route::resource('/notifications', NotificationController::class);   
//     Route::resource('/advices', AdviceController::class);
    
// });

//Admin

Route::middleware(['auth:api', 'isAdmin'])->group(function () {
    Route::post('/logout', [AuthenticateController::class, 'logout']);
    Route::resource('/consumptions', ConsumptionController::class);
    Route::resource('/forums', ForumController::class);
    Route::resource('/comments', CommentController::class);
    Route::resource('/informs', InformsController::class);
    Route::resource('/notifications', NotificationController::class);   
    Route::resource('/advices', AdviceController::class);
});

// Route::prefix(['auth:api','admin'])->middleware('auth')->group(function() {
//     Route::get('/admin', [AdminController::class, 'index']);

// });

Route::middleware('auth:api')->group(function(){    
    Route::post('/logout', [AuthenticateController::class, 'logout']);
    //consumptions ->
    Route::resource('/consumptions', ConsumptionController::class);
    //forums ->
    Route::post('/forums', [ForumController::class, 'store']);
    //comments ->
    Route::post('/comments', [CommentController::class, 'store']);
    //informs ->
    Route::resource('/informs', InformsController::class);
    //notifications ->
    Route::resource('/notifications', NotificationController::class);   
    //advices ->
    Route::resource('/advices', AdviceController::class);
    
});


