<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\authcontroller;
use App\Http\Controllers\API\postcontroller;

Route::post('signup',[authcontroller::class,'signup'])->name('signup');

Route::post('login',[authcontroller::class,'login'])->name('login');


Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout',[authcontroller::class,'logout']);

    Route::apiResource('posts', postcontroller::class);
});
