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
        Schema::create('posts', function (Blueprint $table) {
            // Primary key
            $table->id('post_id');

            // Foreign key to users table
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->onDelete('cascade');

            // Post content
            $table->text('post_content');

            // Category ENUM
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

            // Timestamps and soft delete
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
