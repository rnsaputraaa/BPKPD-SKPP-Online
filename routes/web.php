<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SkppController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'login']);
});

Route::middleware(['auth', 'user', 'prevent-back-history'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [SkppController::class, 'dashboard'])->name('dashboard');
    Route::get('/skpp', [SkppController::class, 'index'])->name('skpp.index');
    Route::get('/skpp/create', [SkppController::class, 'create'])->name('skpp.create');
    Route::post('/skpp', [SkppController::class, 'store'])->name('skpp.store');
    Route::get('/skpp/{skpp}', [SkppController::class, 'show'])->name('skpp.show');
    Route::get('/skpp/{skpp}/print', [SkppController::class, 'print'])->name('skpp.print');
});

Route::middleware(['auth', 'admin', 'prevent-back-history'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/skpp', [AdminController::class, 'skppList'])->name('admin.skpp.index');
    Route::get('/skpp/{skpp}', [AdminController::class, 'skppShow'])->name('admin.skpp.show');
    Route::post('/skpp/{skpp}/approve', [AdminController::class, 'approve'])->name('admin.skpp.approve');
    Route::post('/skpp/{skpp}/reject', [AdminController::class, 'reject'])->name('admin.skpp.reject');
    Route::get('/skpp/{skpp}/print', [AdminController::class, 'print'])->name('admin.skpp.print');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
