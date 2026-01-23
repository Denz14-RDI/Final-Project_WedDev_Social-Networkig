<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notif_id'); // PK - unique ID for each notification
            $table->unsignedBigInteger('user_id'); // FK - user receiving the notification
            $table->index('user_id');
            $table->enum('notif_type', ['new_comment', 'new_like', 'new_friend']); // type of notification
            $table->enum('entity_type', ['user', 'post', 'comment']); // type of entity involved
            $table->unsignedBigInteger('entity_id'); // ID of the entity involved
            $table->json('notif_data');
            $table->timestamp('read_at')->nullable(); // when the notification was read
            $table->timestamp('created_at')->useCurrent(); // when the notification was created
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
