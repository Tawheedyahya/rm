<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\Superadmincontroller;
use Illuminate\Support\Facades\Route;


Route::post('/login', [Authcontroller::class, 'login'])->middleware('throttle:login');
Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/password_change',[Authcontroller::class,'password_change']);
Route::post('/reset_password',[Authcontroller::class,'reset_password'])->middleware('throttle:email');


Route::post('/token/refresh', [Authcontroller::class, 'refresh']);


Route::middleware(['jwt.token'])->group(function () {
    Route::get('/profile', [Authcontroller::class, 'profile']);
    Route::post('/logout', [Authcontroller::class, 'logout']);
});
Route::middleware(['jwt.token','role:super_admin,hospital'])->prefix('super_admin')->name('super_admin.')->group(function(){
    Route::get('/dashboard',[Superadmincontroller::class,'dashbaord']);
});