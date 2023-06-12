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
    Route::delete('users/{id}', [AuthController::class, 'destroy'])->name('users.destroy');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // routes pour les livres
    Route::post('books', [BookController::class, 'store'])->name('books.store');
    Route::patch('books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    // routes pour les commentaires
    Route::post('books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::patch('books/{book}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('books/{book}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
