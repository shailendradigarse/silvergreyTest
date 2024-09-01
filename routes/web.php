<?php

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

Route::view('/', 'auth.login')->middleware('guest')->name('login.page');

Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register.page');

Route::get('/profile', function () {
    return view('auth.profile');
})->middleware('auth:sanctum')->name('profile.page');
