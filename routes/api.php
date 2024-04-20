<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');
});

// auth sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Companies
    Route::controller(CompanyController::class)->prefix('companies')->group(function () {
        Route::get('', 'index');
        Route::post('create', 'store');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');
    });

    // Tasks
    Route::controller(TaskController::class)->prefix('tasks')->group(function () {
        Route::get('', 'index');
        Route::post('create', 'store');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');
    });
});
