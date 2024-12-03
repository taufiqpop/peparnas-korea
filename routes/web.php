<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('index');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/check-access', [HomeController::class, 'rbacCheck'])->name('check-access');
Route::post('/check-access', [HomeController::class, 'chooseRole'])->name('choose-role');
Route::get('/menus', [HomeController::class, 'loadMenu'])->name('load-menu');
