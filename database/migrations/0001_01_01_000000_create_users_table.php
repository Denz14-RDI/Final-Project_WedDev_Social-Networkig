<?php
// ------------------------------------------------------------
// User System Migration
// ------------------------------------------------------------
// This migration sets up the foundation of the user system.
// It creates three tables:
// 1. users – where all account details are stored.
// 2. password_reset_tokens – used when someone requests to reset their password.
// 3. sessions – keeps track of who is logged in and their activity.
// ------------------------------------------------------------

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // --------------------
        // Users Table
        // --------------------
        // Stores basic account details like name, username, email,
        // password, bio, profile picture, and role (member/admin).
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Primary key
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->text('bio')->nullable();
            $table->string('profile_pic')->nullable();
            $table->enum('role', ['member', 'admin'])->default('member');
            $table->timestamps(); // created_at and updated_at
        });

        // --------------------
        // Password Reset Tokens Table
        // --------------------
        // Keeps track of password reset requests.
        // Each email has one token and a timestamp.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // --------------------
        // Sessions Table
        // --------------------
        // Tracks user sessions for login persistence.
        // Includes session ID, user ID, IP address, user agent,
        // payload data, and last activity timestamp.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        // Drops all three tables if migration is rolled back
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
