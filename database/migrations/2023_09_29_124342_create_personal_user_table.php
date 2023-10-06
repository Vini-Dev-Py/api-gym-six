<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_user', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->foreignUuid('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('id_personal_code')->constrained('personal_code')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_user');
    }
};
