<?php
// ------------------------------------------------------------
// Posts Migration
// ------------------------------------------------------------
// This migration sets up the posts table.
// It stores all user posts, including their content,
// category, optional image, and timestamps.
// Posts are linked to users and can be soft-deleted.
// ------------------------------------------------------------

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // --------------------
    // Run the migrations
    // --------------------
    // Creates the posts table with fields for content,
    // category, optional media, and user relationship.
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            // Primary key
            $table->id('post_id');

            // Link each post to a user (foreign key)
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade'); // delete posts if user is deleted

            // Post content
            $table->text('post_content');

            // Category (limited to specific options)
            $table->enum('category', [
                'academic',
                'events',
                'announcement',
                'campus_life',
                'help_wanted'
            ]);

            // Optional image and link
            $table->string('image')->nullable();
            $table->string('link')->nullable();

            // Timestamps (created_at, updated_at) and soft delete (deleted_at)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // --------------------
    // Reverse the migrations
    // --------------------
    // Drops the posts table if migration is rolled back.
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};