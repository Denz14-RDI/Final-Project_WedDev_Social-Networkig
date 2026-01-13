<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', fn () => view('welcome'))->name('welcome');

Route::get('/login', fn () => view('auth.login'))->name('login');
Route::get('/register', fn () => view('auth.register'))->name('register');

Route::get('/feed', fn () => view('feed'))->name('feed');
Route::get('/search', fn () => view('search'))->name('search');

Route::get('/notifications', fn () => view('notifications'))->name('notifications');
Route::get('/profile', fn () => view('profile'))->name('profile');
Route::get('/friends', fn () => view('friends'))->name('friends');
Route::get('/settings', fn () => view('settings'))->name('settings');

/*
|--------------------------------------------------------------------------
| Logout (needed for your sidebar button)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login'); // or ->route('welcome')
})->name('logout');
