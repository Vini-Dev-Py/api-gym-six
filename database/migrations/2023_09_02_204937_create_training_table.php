<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('exercise_name');
            $table->string('url_video_img');
            $table->string('sets');
            $table->string('repes');
            $table->string('rest_time');
            $table->string('day');
            $table->foreignUuid('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('id_personal_code')->constrained('personal_code')->onDelete('cascade');
            $table->integer('position');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training');
    }
};
