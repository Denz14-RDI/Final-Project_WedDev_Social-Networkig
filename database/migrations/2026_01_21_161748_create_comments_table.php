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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('com_id'); // primary key

            $table->unsignedBigInteger('post_id'); // foreign key to posts table
            $table->unsignedBigInteger('user_id'); // foreign key to users table

            // foreign key to posts table
            $table->foreign('post_id')
                    ->references('post_id')
                    ->on('posts')
                    ->onDelete('cascade');
            
            // foreign key to users table
            $table->foreign('user_id')
                    ->references('user_id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->text('com_content'); // comment content
            
            $table->timestamps(); // created_at and updated_at

            $table->softDeletes(); // (nullable) deleted_at for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
