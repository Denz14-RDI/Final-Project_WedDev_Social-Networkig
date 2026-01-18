<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\Report;

// Route model bindings
Route::model('post', Post::class);
Route::model('comment', Comment::class);
Route::model('friend', Friend::class);
Route::model('notification', Notification::class);
Route::model('report', Report::class);

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', fn() => view('welcome'))->name('welcome');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
Route::get('/sign-in', fn() => view('auth.signin-choice'))->name('signin.choice');
Route::get('/admin/login', fn() => view('auth.admin-login'))->name('admin.login');
/*
|--------------------------------------------------------------------------
| Authenticated Routes (User Dashboard & Features)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Feed and Posts
    Route::get('/feed', [PostController::class, 'feed'])->name('feed');
    Route::resource('posts', PostController::class)->except(['destroy']);
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Comments
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::patch('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Likes
    Route::post('posts/{post}/like', [LikeController::class, 'toggle'])->name('likes.toggle');
    Route::get('posts/{post}/like-count', [LikeController::class, 'count'])->name('likes.count');

    // Friends
    Route::get('/friends', [FriendController::class, 'index'])->name('friends');
    Route::post('users/{user}/friend-request', [FriendController::class, 'store'])->name('friends.store');
    Route::patch('friends/{friend}/accept', [FriendController::class, 'accept'])->name('friends.accept');
    Route::patch('friends/{friend}/decline', [FriendController::class, 'decline'])->name('friends.decline');
    Route::patch('friends/{friend}/unfriend', [FriendController::class, 'unfriend'])->name('friends.unfriend');
    Route::post('users/{user}/block', [FriendController::class, 'block'])->name('friends.block');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::patch('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Reports
    Route::get('posts/{post}/report', [ReportController::class, 'create'])->name('reports.create');
    Route::post('reports', [ReportController::class, 'store'])->name('reports.store');

    // User Profile & Settings
    Route::get('/profile/{user}', [UserController::class, 'show'])->name('profile.show');
    Route::get('/settings', [UserController::class, 'edit'])->name('settings');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');

    // User Dashboard
    Route::get('/search', fn() => view('search'))->name('search');
    Route::get('/profile', fn() => view('profile'))->name('profile');
    Route::get('/settings', fn() => view('settings'))->name('settings');
});
/*
|--------------------------------------------------------------------------
| Admin Pages (Views)
|--------------------------------------------------------------------------
| NOTE: For now, I’m only protecting it with "auth".
| Later you can add an "admin" middleware to prevent normal users.
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', fn() => redirect()->route('admin.dashboard'));

        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        Route::view('/moderation', 'admin.moderation')->name('moderation');
        Route::view('/users', 'admin.users')->name('users');
        Route::view('/posts', 'admin.posts')->name('posts');
        Route::view('/banned', 'admin.banned')->name('banned');
        Route::view('/settings', 'admin.settings')->name('settings');

        // Admin Report Management
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::patch('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    });


Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
