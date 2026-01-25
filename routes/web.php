<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminSettingsController;
use App\Models\Notification;

// --------------------
// Public pages
// --------------------
//  These routes are accessible to everyone, even guests.
//  They typically show landing pages, login, and registration.
// --------------------
// Landing page showing a welcome screen for guests
Route::get('/', fn() => view('welcome'))->name('welcome');

// --------------------
// Member Login Authentication
// --------------------
// Routes for user login, sign-in choice, and registration.
// Guests use these to access or create accounts.
// --------------------
// Show a login form with email/username and password field
Route::get('/login', fn() => view('auth.login'))->name('login');

// Handles login submission via AuthController
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Sign-in choice page where you can choose logging in as community member and admin
Route::get('/sign-in', fn() => view('auth.signin-choice'))->name('signin.choice');

// Show a registration form with first and last name, username, email, and password with confirm password fields
Route::get('/register', fn() => view('auth.register'))->name('register');

// Handles user registration via UserController
Route::post('/register', [UserController::class, 'store'])->name('register.store');

// --------------------
// Admin login Authentication
// --------------------
// Routes for admin login and logout.
// These are separate from user login to enforce role separation
// --------------------
// Shows a login form with email and password field
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

// Handles admin login submission via AdminAuthController
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Handles admin logout process via AdminAuthController
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// --------------------
// Authenticated routes
// --------------------
// These routes are only accessible to logged-in users.
// The 'auth' middleware ensures guests are redirected to login.
// --------------------
Route::middleware('auth')->group(function () {
    // --------------------
    // Feed & Posts
    // --------------------
    // Show the main community feed and list of posts
    Route::get('/feed', [PostController::class, 'index'])->name('feed');

    // Create a new post via PostController with a Modal (create-post-modal)
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    
    // Show a single post by its ID
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
   
    // Can edit post via PostController with a Modal (create-post-modal)
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');

    // Handles updated post
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    
    // Handles delete post
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // --------------------
    // Reports
    // --------------------
    // Report a post via ReportController with (create-report-modal)
    Route::post('/posts/{post}/report', [ReportController::class, 'store'])->name('posts.report');

    // --------------------
    // Likes
    // --------------------
    // Toggle button that allows user to like/unlike a post via LikeController
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle']) ->middleware('auth')->name('posts.like');

    // --------------------
    // Comments
    // --------------------
    // Shows list of comments on a post
    Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
    
    // Add a new comment to a post via CommentController
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // Update an existing comment on a post
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
   
    // Delete an existing comment on a post
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Notifications (Blade page)
    Route::get('/notifications', [NotificationController::class, 'page'])
        ->name('notifications');

    // Notifications 
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])
        ->name('notifications.unread');

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.markAllAsRead');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Notifications, Settings
    //Route::get('/notifications', fn() => view('notifications'))->name('notifications');
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
        return redirect()->route('signin.choice');
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

        // Admin Settings actions
        Route::view('/settings', 'admin.settings')->name('settings');
        Route::post('/settings/update-password', [AdminSettingsController::class, 'updatePassword'])
            ->name('updatePassword');
    });
