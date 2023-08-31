<?php

use App\Http\Controllers\DocumentManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Auth::routes();

Route::middleware('auth')->prefix('page')->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('document')->group(function(){
        Route::get('/grid', [DocumentManagementController::class, 'index'])->name('doc');
        Route::get('/create', [DocumentManagementController::class, 'create'])->name('create.doc');
        Route::post('/store', [DocumentManagementController::class, 'store'])->name('store.doc');
        
        Route::get('/show/{id}/doc', [DocumentManagementController::class, 'show'])->name('show.doc');
        Route::get('/edit/{id}/doc', [DocumentManagementController::class, 'edit'])->name('edit.doc');
        Route::put('/update/{id}/doc', [DocumentManagementController::class, 'update'])->name('update.doc');
        Route::delete('/delete/{id}', [DocumentManagementController::class, 'destroy'])->name('destroy.doc');
    });

    Route::prefix('user')->group(function(){
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('/edit/{id}/profile', [UserController::class, 'edit'])->name('edit.profile');
        Route::put('/update/{id}/profile', [UserController::class, 'update'])->name('update.profile');
    });
});


Route::get('/logic', [LogicController::class, 'index']);

// https://documenter.getpostman.com/view/26360687/2s9Y5bQ1rX