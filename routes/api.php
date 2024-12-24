<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/reports', [APIController::class, 'reports']);
Route::get('/categories', [APIController::class, 'categories']);
Route::get('/regions', [APIController::class, 'regions']);
