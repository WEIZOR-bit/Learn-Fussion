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
        Schema::create('challenges_completed', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('challenge_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('checked_by');

            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('checked_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenges_completed');
    }
};
