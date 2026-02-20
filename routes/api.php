<?php

use App\Http\Controllers\Authcontroller;
use Illuminate\Support\Facades\Route;

// Public routes (no authentication required)
Route::post('/login', [Authcontroller::class, 'login'])->middleware('throttle:login');
Route::post('/register', [Authcontroller::class, 'register']);

// Token refresh - can be called with expired access token
Route::post('/token/refresh', [Authcontroller::class, 'refresh']);

// Protected routes (require valid access token with type='access')
Route::middleware(['jwt.token'])->group(function () {
    Route::get('/profile', [Authcontroller::class, 'profile']);
    Route::post('/logout', [Authcontroller::class, 'logout']);
    
    // Add more protected routes here
    // Route::get('/dashboard', [DashboardController::class, 'index']);
});

// Optional: Admin routes with additional middleware
// Route::middleware(['jwt.auth', 'admin'])->group(function () {
//     Route::get('/admin/users', [AdminController::class, 'users']);
// });