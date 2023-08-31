<?php

use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use Illuminate\Http\Request;
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
Route::get('/s', function(){
    return User::all();
});
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('user/show', [UserController::class, 'show']);
    Route::post('user/update', [UserController::class, 'update']);
    Route::get('logout', [UserController::class, 'logout']);
    
    Route::get('document', [DocumentController::class, 'index']);
    Route::post('document', [DocumentController::class, 'create']);
    Route::post('document/{id}', [DocumentController::class, 'update']);
    Route::delete('document/{id}', [DocumentController::class, 'delete']);
});
