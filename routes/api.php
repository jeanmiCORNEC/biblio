<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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


// routes pour les livres
Route::apiResource('books', BookController::class);

// routes pour les utilisateurs
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

// routes protégées
Route::middleware('auth:sanctum')->group(function () {
    // routes pour les utilisateurs
    Route::get('users/{id}', [AuthController::class, 'show'])->name('users.show');
    Route::put('users/{id}', [AuthController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [AuthController::class, 'destroy'])->name('users.destroy');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
