<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/about', [IndexController::class, 'about'])->name('about');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.store');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'create'])->name('register.store');
});

Route::middleware('auth')->group(function () {


    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');
    Route::get('/statistics', [IndexController::class, 'statistics'])->name('statistics');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');

    Route::middleware('role:Admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/verification/{user}', [UserController::class, 'verification'])->name('users.verification');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/about', [AboutController::class, 'index'])->name('about');
        Route::put('/about/{about}', [AboutController::class, 'update'])->name('about.update');

        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::put('/contact/{contact}', [ContactController::class, 'update'])->name('contact.update');

        Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');
        Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
        Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
    });

    Route::middleware('role:Goverment,Citizen')->group(function () {
        Route::post('/reports/comment/{report}', [ReportController::class, 'comment'])->name('reports.comment');
    });

    Route::middleware('role:Goverment,Admin')->group(function () {
        Route::patch('/reports/verification/{report}', [ReportController::class, 'verification'])->name('reports.verification');
    });

    Route::middleware('role:Citizen')->group(function () {
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    });

    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/show/{report}', [ReportController::class, 'show'])->name('reports.show');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});
