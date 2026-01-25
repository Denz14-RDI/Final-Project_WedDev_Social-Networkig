<?php
// ------------------------------------------------------------
// Comments Migration
// ------------------------------------------------------------
// This migration sets up the comments table.
// It stores user comments made on posts,
// links each comment to both the post and the user,
// and supports timestamps and soft deletion.
// ------------------------------------------------------------

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // --------------------
    // Run the migrations
    // --------------------
    // Creates the comments table with fields for post link,
    // user link, comment content, timestamps, and soft deletion.
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id('com_id'); // Primary key

            // Link to the post being commented on
            $table->unsignedBigInteger('post_id');

            // Link to the user who wrote the comment
            $table->unsignedBigInteger('user_id');

            // Foreign key constraints
            $table->foreign('post_id')
                  ->references('post_id')
                  ->on('posts')
                  ->onDelete('cascade'); // delete comments if post is deleted
            
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade'); // delete comments if user is deleted

            // The actual text of the comment
            $table->text('com_content');

            // Track when the comment was created/updated
            $table->timestamps();

            // Allow soft deletion (comment can be hidden but not permanently removed)
            $table->softDeletes();
        });
    }

    // --------------------
    // Reverse the migrations
    // --------------------
    // Drops the comments table if migration is rolled back.
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};