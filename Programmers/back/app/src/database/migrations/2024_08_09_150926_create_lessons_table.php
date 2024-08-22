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
        Schema::create('lessons', function (Blueprint $table) {
            $table->softDeletes();
            $table->id();
            $table->unsignedTinyInteger('order');
            $table->string('name');
            $table->string('description');
            $table->string('tutorial_link')->nullable();
            $table->float('average_rating');
            $table->unsignedBigInteger('review_count');
            $table->unsignedTinyInteger('question_count');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
