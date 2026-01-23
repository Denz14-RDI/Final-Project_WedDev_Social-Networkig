<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminSettingsController; 

// --------------------
// Public pages
// --------------------
Route::get('/', fn() => view('welcome'))->name('welcome');

// Authentication
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/sign-in', fn() => view('auth.signin-choice'))->name('signin.choice');

// Admin login
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Registration
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

// --------------------
// Authenticated routes
// --------------------
Route::middleware('auth')->group(function () {

    // Feed & Posts
    Route::get('/feed', [PostController::class, 'index'])->name('feed');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Reports (user side)
    Route::post('/posts/{post}/report', [ReportController::class, 'store'])->name('posts.report');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Notifications, Settings
    Route::get('/notifications', fn() => view('notifications'))->name('notifications');
    Route::get('/settings', fn() => view('settings'))->name('settings');

    // Friends / follow system
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends/{user}', [FriendController::class, 'store'])->name('friends.store');
    Route::post('/friends/{user}/unfollow', [FriendController::class, 'unfollow'])->name('friends.unfollow');

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
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', fn() => redirect()->route('admin.dashboard'));

        // Dashboard
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        // Moderation panel (supports ?tab=pending|resolved|dismissed)
        Route::get('/moderation', [ReportController::class, 'moderationView'])->name('reports.moderation');

        // Report management
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::put('/reports/{report}/status', [ReportController::class, 'updateStatus'])->name('reports.updateStatus');

        // Admin views
        Route::view('/users', 'admin.users')->name('users');
        Route::view('/posts', 'admin.posts')->name('posts');
        Route::view('/banned', 'admin.banned')->name('banned');
        Route::view('/settings', 'admin.settings')->name('settings');

        // Admin Settings actions
        Route::post('/settings/update-password', [AdminSettingsController::class, 'updatePassword'])
            ->name('updatePassword');
    });