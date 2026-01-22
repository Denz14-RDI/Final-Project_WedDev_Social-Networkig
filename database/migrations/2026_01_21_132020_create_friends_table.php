<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id('friend_id'); // Primary key
            $table->foreignId('user_id_1')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('user_id_2')->constrained('users', 'user_id')->onDelete('cascade');
            $table->enum('status', ['follow', 'following', 'unfollow'])->default('follow');
            $table->timestamps();

            $table->softDeletes(); 

            $table->unique(['user_id_1', 'user_id_2']); // Ensure unique friends
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
