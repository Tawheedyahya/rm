<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;


Route::get('/set', function() {
    Cache::put('iqra', 'works', 60);
    echo Cache::get('iqra');
});

Route::get('/get', function() {
    return Cache::store('redis')->get('name', 'not found');
});