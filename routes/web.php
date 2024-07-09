<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Projects\TaskController;
use App\Http\Controllers\Users\DashboardController;
use App\Http\Controllers\Projects\ProjectsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|*/


Route::get('/', [LoginController::class, 'showLoginForm']);
Route::post('v1/login', [LoginController::class, 'accountAuth']);
Route::get('v1/logout', [LoginController::class, 'logout']);

Route::middleware(['auth.filter'])
    ->prefix('v1/dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class,'index']);
        Route::get('details', [DashboardController::class,'dashDetails']);
    });

Route::middleware(['auth.filter'])
    ->prefix('v1/projects')
    ->group(function () {
    Route::get('/', [ProjectsController::class,'index']);
    Route::post('/add', [ProjectsController::class,'create']);
    Route::get('/tasks/{id}', [ProjectsController::class,'tasks']);
    Route::post('/tasks/update/{id}', [ProjectsController::class,'editTask']);
    Route::post('/tasks/delete/{id}', [ProjectsController::class,'removeTask']);
});

Route::middleware(['auth.filter'])
    ->prefix('v1/tasks')
    ->group(function () {
    Route::get('/', [TaskController::class,'index']);
    Route::post('/add', [TaskController::class,'create']);
    Route::post('/update/{id}', [TaskController::class,'edit']);
    Route::post('/delete/{id}', [TaskController::class,'removeTask']);
    Route::get('/reorder', [TaskController::class,'reOrder']);
});

Route::get('/logout', [LoginController::class, 'logout']);

