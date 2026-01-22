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
            // Primary Key
            $table->id('report_id');

            // Foreign Keys
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('reported_by');

            // Relationships
            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            $table->foreign('reported_by')->references('user_id')->on('users')->onDelete('cascade');

            // ENUM fields
            $table->enum('reason', ['spam', 'harassment', 'misinformation', 'inappropriate', 'other']);
            $table->text('details')->nullable();
            $table->enum('status', ['pending', 'resolved', 'dismissed'])->default('pending');

            // Timestamps
            $table->timestamps(); // created_at, updated_at
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