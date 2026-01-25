<?php
// ------------------------------------------------------------
// Friends Migration
// ------------------------------------------------------------
// This migration sets up the friends table.
// It keeps track of relationships between users,
// including whether they are following, unfollowing,
// or just in a "follow" state.
// ------------------------------------------------------------

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // --------------------
    // Run the migrations
    // --------------------
    // Creates the friends table with fields for user relationships,
    // status, timestamps, and soft deletion.
    public function up(): void
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id('friend_id'); // Primary key

            // Link between two users
            $table->foreignId('user_id_1')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');

            $table->foreignId('user_id_2')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');

            // Relationship status (follow, following, unfollow)
            $table->enum('status', ['follow', 'following', 'unfollow'])->default('follow');

            // Track when the relationship was created/updated
            $table->timestamps();

            // Allow soft deletion (relationship can be hidden but not permanently removed)
            $table->softDeletes();

            // Prevent duplicate relationships between the same two users
            $table->unique(['user_id_1', 'user_id_2']);
        });
    }

    // --------------------
    // Reverse the migrations
    // --------------------
    // Drops the friends table if migration is rolled back.
    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};