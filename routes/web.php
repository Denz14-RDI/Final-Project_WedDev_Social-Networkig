<?php

use Illuminate\Support\Facades\Route;



Route::get('/', fn () => view('welcome'))->name('welcome');

Route::get('/login', fn () => view('auth.login'))->name('login');
Route::get('/register', fn () => view('auth.register'))->name('register');

Route::get('/feed', fn () => view('feed'))->name('feed');
Route::get('/search', fn () => view('search'))->name('search');

Route::get('/notifications', fn () => view('notifications'))->name('notifications');
Route::get('/profile', fn () => view('profile'))->name('profile');
Route::get('/friends', fn () => view('friends'))->name('friends');