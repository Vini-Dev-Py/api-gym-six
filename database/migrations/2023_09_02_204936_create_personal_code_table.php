<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_code', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('personal_code')->unique();
            $table->foreignUuid('id_user')->constrained('users')->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_code');
    }
};
