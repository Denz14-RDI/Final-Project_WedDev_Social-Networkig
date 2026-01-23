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
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('report_id'); // Primary key
            $table->unsignedBigInteger('post_id'); // FK to posts
            $table->unsignedBigInteger('reported_by'); // FK to users

            // ✅ Restrict reason values to known categories
            $table->enum('reason', [
                'spam',
                'harassment',
                'misinformation',
                'inappropriate',
                'other'
            ]);

            $table->text('details')->nullable(); // optional details
            $table->string('status')->default('pending'); // pending, resolved, dismissed
            $table->timestamps();

            // ✅ Unique constraint: one user can only report a post once
            $table->unique(['post_id', 'reported_by']);

            // ✅ Index for faster lookups by status
            $table->index('status');

            // ✅ Foreign keys
            $table->foreign('post_id')
                  ->references('post_id')->on('posts')
                  ->onDelete('cascade');

            $table->foreign('reported_by')
                  ->references('user_id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};