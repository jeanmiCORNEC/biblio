<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\BookController as AdminBookController;

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
Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');

// routes pour les utilisateurs
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

// routes protégées
Route::middleware('auth:sanctum')->group(function () {
    // routes pour les utilisateurs
    Route::get('users/{id}', [AuthController::class, 'show'])->name('users.show');
    Route::put('users/{id}', [AuthController::class, 'update'])->name('users.update');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('users/{id}', [AuthController::class, 'destroy'])->name('users.destroy');

    // routes pour les commentaires
    Route::post('books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // partie admin avec son propre middleware
    Route::middleware('admin')->name('admin.')->prefix('admin')->group(function () {
        // routes pour les livres
        Route::post('books', [AdminBookController::class, 'store'])->name('books.store');
        Route::patch('books/{book}', [AdminBookController::class, 'update'])->name('books.update');
        Route::delete('books/{book}', [AdminBookController::class, 'destroy'])->name('books.destroy');
    });
});
