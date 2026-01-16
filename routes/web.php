<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', fn() => view('welcome'))->name('welcome');

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');

Route::get('/feed', fn() => view('feed'))->name('feed');
Route::get('/search', fn() => view('search'))->name('search');

Route::get('/notifications', fn() => view('notifications'))->name('notifications');
Route::get('/profile', fn() => view('profile'))->name('profile');
Route::get('/friends', fn() => view('friends'))->name('friends');
Route::get('/settings', fn() => view('settings'))->name('settings');

Route::get('/sign-in', fn() => view('auth.signin-choice'))->name('signin.choice');

Route::get('/admin/login', fn() => view('auth.admin-login'))->name('admin.login');


/*
|--------------------------------------------------------------------------
| Admin Pages (Views)
|--------------------------------------------------------------------------
| NOTE: For now, I’m only protecting it with "auth".
| Later you can add an "admin" middleware to prevent normal users.
*/
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn() => redirect()->route('admin.dashboard'));

        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        Route::view('/moderation', 'admin.moderation')->name('moderation');
        Route::view('/users', 'admin.users')->name('users');
        Route::view('/posts', 'admin.posts')->name('posts');
        Route::view('/banned', 'admin.banned')->name('banned');
        Route::view('/settings', 'admin.settings')->name('settings');
    });


Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');
