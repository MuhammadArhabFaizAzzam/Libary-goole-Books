<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\User\DashboardController as UserDashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
});

// Library Routes - Require Auth
Route::middleware('auth')->name('library.')->prefix('library')->group(function () {
    Route::get('/', [LibraryController::class, 'home'])->name('home');
    Route::get('/books', [LibraryController::class, 'books'])->name('books');
    Route::get('/my-books', [LibraryController::class, 'myBooks'])->name('my.books');
    Route::get('/book/{googleId}', [LibraryController::class, 'show'])->name('book.detail');
    Route::post('/book/{googleId}/save', [LibraryController::class, 'save'])->name('book.save');
    Route::delete('/book/{googleId}/unsave', [LibraryController::class, 'unsave'])->name('book.unsave');
});

require __DIR__.'/settings.php';

