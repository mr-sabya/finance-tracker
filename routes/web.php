<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
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


Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::view('profile', 'profile')
    ->name('profile');


    Route::get('resource', [App\Http\Controllers\ResourceController::class, 'index'])->name('resource.index');
    Route::get('income', [App\Http\Controllers\IncomeController::class, 'index'])->name('income.index');

    Route::get('category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::get('expense', [App\Http\Controllers\ExpenseController::class, 'index'])->name('expense.index');

    Route::get('report', [App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
});

// require __DIR__.'/auth.php';
