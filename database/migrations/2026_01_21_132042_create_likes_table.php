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
        Schema::create('likes', function (Blueprint $table) {
            $table->id('like_id'); // PK - unique ID for each like

            // foreign keys
            $table->foreignId('post_id')
                  ->constrained('posts', 'post_id')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');

            // created_at & updated_at
            $table->timestamps();

            // deleted_at (soft delete)
            $table->softDeletes();

            // constraint - one like per user per post
            $table->unique(['post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
