<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

// --------------------
// Public pages
// --------------------
Route::get('/', fn() => view('welcome'))->name('welcome');

// Authentication
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/sign-in', fn() => view('auth.signin-choice'))->name('signin.choice');
Route::get('/admin/login', fn() => view('auth.admin-login'))->name('admin.login');

// Registration
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

// --------------------
// Authenticated routes
// --------------------
Route::middleware('auth')->group(function () {

    // Feed (dynamic posts)
    Route::get('/feed', [PostController::class, 'index'])->name('feed');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit'); // ✅ added
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); // ✅ added
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Search
    Route::get('/search', fn() => view('search'))->name('search');

    // Notifications, Friends, Settings
    Route::get('/notifications', fn() => view('notifications'))->name('notifications');
    Route::get('/friends', fn() => view('friends'))->name('friends');
    Route::get('/settings', fn() => view('settings'))->name('settings');

    // Profile
    Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show');
    Route::put('/profile/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{id}', [UserController::class, 'destroy'])->name('profile.destroy');

    // Shortcut for logged-in user's profile
    Route::get('/profile', function () {
        return redirect()->route('profile.show', ['id' => Auth::id()]);
    })->name('profile');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

// --------------------
// Admin routes
// --------------------
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