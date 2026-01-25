<?php
// ------------------------------------------------------------
// Reports Migration
// ------------------------------------------------------------
// This migration sets up the reports table.
// It stores reports made by users against posts,
// including the reason, optional details, and status.
// Each report is linked to both the post and the user
// who submitted it, with safeguards to prevent duplicates.
// ------------------------------------------------------------

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // --------------------
    // Run the migrations
    // --------------------
    // Creates the reports table with fields for post link,
    // user link, reason, details, status, and timestamps.
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('report_id'); // Primary key

            // Link to the post being reported
            $table->unsignedBigInteger('post_id');

            // Link to the user who submitted the report
            $table->unsignedBigInteger('reported_by');

            // Reason for the report (restricted to known categories)
            $table->enum('reason', [
                'spam',
                'harassment',
                'misinformation',
                'inappropriate',
                'other'
            ]);

            // Optional extra details about the report
            $table->text('details')->nullable();

            // Status of the report (pending, resolved, dismissed)
            $table->string('status')->default('pending');

            // Track when the report was created/updated
            $table->timestamps();

            // Prevent duplicate reports (one user can only report a post once)
            $table->unique(['post_id', 'reported_by']);

            // Index for faster lookups by status
            $table->index('status');

            // Foreign key constraints
            $table->foreign('post_id')
                  ->references('post_id')->on('posts')
                  ->onDelete('cascade');

            $table->foreign('reported_by')
                  ->references('user_id')->on('users')
                  ->onDelete('cascade');
        });
    }

    // --------------------
    // Reverse the migrations
    // --------------------
    // Drops the reports table if migration is rolled back.
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};