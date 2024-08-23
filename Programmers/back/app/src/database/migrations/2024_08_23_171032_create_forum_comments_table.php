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
        Schema::create('forum_comments', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->unsignedBigInteger('user_id)');
            $table->unsignedBigInteger('post_id)');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('forum_posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_comments');
    }
};
