<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\Staffcontroller;
use App\Http\Controllers\Superadmincontroller;
use App\Http\Controllers\TableController;
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
Route::middleware(['jwt.token','role:super_admin'])->prefix('super_admin')->name('super_admin.')->group(function(){
    Route::get('/hotel_lists',[Superadmincontroller::class,'index']);
    Route::post('/create_hotel',[Superadmincontroller::class,'create_hotel']);
    Route::put('/update_hotel/{id}',[Superadmincontroller::class,'create_hotel']);
    Route::get('/hotel/{id}',[Superadmincontroller::class,'show_hotel']);
});
Route::middleware(['jwt.token','role:hotel_admin,waiter'])->prefix('table')->name('table.')->group(function(){
    Route::post('/create_table',[TableController::class,'store']);
});
Route::middleware(['jwt.token','role:hotel_admin'])->prefix('staff')->name('staff.')->group(function(){
    Route::post('/create_staff',[Staffcontroller::class,'store']);   
});