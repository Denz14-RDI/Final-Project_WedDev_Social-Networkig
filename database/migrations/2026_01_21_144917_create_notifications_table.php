<?php
// ------------------------------------------------------------
// Notifications Migration
// ------------------------------------------------------------
// This migration sets up the notifications table.
// It stores alerts for users when certain actions happen,
// such as new comments, likes, or friend requests.
// Each notification is linked to a user and includes
// details about the event, whether it has been read,
// and when it was created.
// ------------------------------------------------------------

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // --------------------
    // Run the migrations
    // --------------------
    // Creates the notifications table with fields for type,
    // related entity, extra data, and read status.
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notif_id'); // Primary key - unique ID for each notification

            // User who receives the notification
            $table->unsignedBigInteger('user_id'); 
            $table->index('user_id'); // Index for faster lookups

            // Type of notification (comment, like, friend)
            $table->enum('notif_type', ['new_comment', 'new_like', 'new_friend']);

            // Entity involved (user, post, or comment)
            $table->enum('entity_type', ['user', 'post', 'comment']);
            $table->unsignedBigInteger('entity_id'); // ID of the entity involved

            // Extra details stored as JSON (e.g., actor info)
            $table->json('notif_data');

            // When the notification was read (nullable if unread)
            $table->timestamp('read_at')->nullable();

            // When the notification was created
            $table->timestamp('created_at')->useCurrent();
        });
    }

    // --------------------
    // Reverse the migrations
    // --------------------
    // Drops the notifications table if migration is rolled back.
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};