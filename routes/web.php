<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});


Route::get('/signup', function () {
    return view('signup');
})->name('signup.page');


Route::post('/register', 'API\AuthController@signup')->name('api.signup');
Route::view('allpost','allpost');
Route::view('addpost','addpost');
