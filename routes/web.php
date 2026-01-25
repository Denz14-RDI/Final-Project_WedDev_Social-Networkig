<?php
// ------------------------------------------------------------
// Web
// ------------------------------------------------------------
// web.php defines all application routes
// mapping URLs to controllers/views with 
// middleware for access control
// ------------------------------------------------------------

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
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->middleware('auth')->name('posts.like');

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

    // --------------------
    // Notifications
    // --------------------
    // Routes for viewing and managing user notifications.
    // Includes unread, mark-as-read, and mark-all-as-read actions.
    // --------------------

    // Show notifications page (Blade view)
    Route::get('/notifications', [NotificationController::class, 'page'])->name('notifications');

    // Show unread notifications only
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');

    // Mark a single notification as read
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Mark all notifications as read
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // --------------------
    // Search
    // --------------------
    // Route for searching posts, profiles, or other content.
    // --------------------
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // --------------------
    // Settings
    // --------------------
    // User settings page (basic preferences).
    // --------------------
    Route::get('/settings', fn() => view('settings'))->name('settings');

    // --------------------
    // Friends / Follow System
    // --------------------
    // Routes for following/unfollowing users and viewing friends list.
    // --------------------

    // Show friends list
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');

    // Follow a user
    Route::post('/friends/{user}', [FriendController::class, 'store'])->name('friends.store');

    // Unfollow a user
    Route::post('/friends/{user}/unfollow', [FriendController::class, 'unfollow'])->name('friends.unfollow');

    // --------------------
    // Profile
    // --------------------
    // Routes for viewing, updating, and deleting user profiles.
    // Includes shortcut to logged-in user's own profile.
    // --------------------

    // Show user profile by ID
    Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show');

    // Update user profile
    Route::put('/profile/{id}', [UserController::class, 'update'])->name('profile.update');

    // Delete user profile - Save this for future update
    Route::delete('/profile/{id}', [UserController::class, 'destroy'])->name('profile.destroy');

    // Shortcut: show logged-in user's own profile
    Route::get('/profile', function () {
        return redirect()->route('profile.show', ['id' => Auth::id()]);
    })->name('profile');

    // --------------------
    // Logout
    // --------------------
    // Logs out the user invalidates session, and regenerates CSRF token.
    // --------------------
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('signin.choice');
    })->name('logout');
});

// --------------------
// Admin Routes
// --------------------
// These routes are only accessible to admins.
// Protected by both 'auth' and 'admin' middleware.
// Handles moderation, reports, and admin settings.
// --------------------
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Redirect /admin to dashboard
        Route::get('/', fn() => redirect()->route('admin.dashboard'));

        // --------------------
        // Dashboard
        // --------------------
        // Show the main admin dashboard view
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        // --------------------
        // Moderation Panel
        // --------------------
        // Admin view for handling reports
        // Supports ?tab=pending|resolved|dismissed query filters
        Route::get('/moderation', [ReportController::class, 'moderationView'])->name('reports.moderation');

        // --------------------
        // Report Management
        // --------------------
        // Show list of all reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        // Show details of a single report
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');

        // Update the status of a report (pending, resolved, dismissed)
        Route::put('/reports/{report}/status', [ReportController::class, 'updateStatus'])->name('reports.updateStatus');

        // --------------------
        // Admin Settings
        // --------------------
        // Show admin settings page
        Route::view('/settings', 'admin.settings')->name('settings');

        // Handle admin password update via AdminSettingsController
        Route::post('/settings/update-password', [AdminSettingsController::class, 'updatePassword'])
            ->name('updatePassword');
    });