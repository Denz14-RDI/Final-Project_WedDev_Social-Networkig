<?php
// ------------------------------------------------------------
// Likes Migration
// ------------------------------------------------------------
// This migration sets up the likes table.
// It records which users have liked which posts,
// ensures each user can only like a post once,
// and supports soft deletion for undoing likes.
// ------------------------------------------------------------

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // --------------------
    // Run the migrations
    // --------------------
    // Creates the likes table with fields for post link,
    // user link, timestamps, and soft deletion.
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id('like_id'); // Primary key - unique ID for each like

            // Link to the post being liked
            $table->foreignId('post_id')
                  ->constrained('posts', 'post_id')
                  ->onDelete('cascade'); // delete likes if post is deleted

            // Link to the user who liked the post
            $table->foreignId('user_id')
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade'); // delete likes if user is deleted

            // Track when the like was created/updated
            $table->timestamps();

            // Allow soft deletion (like can be undone without permanent removal)
            $table->softDeletes();

            // Prevent duplicate likes (one like per user per post)
            $table->unique(['post_id', 'user_id']);
        });
    }

    // --------------------
    // Reverse the migrations
    // --------------------
    // Drops the likes table if migration is rolled back.
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};