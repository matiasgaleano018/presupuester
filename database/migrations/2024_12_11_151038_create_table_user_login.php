<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_login', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('expires_at', precision: 0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_unicode_ci');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_login');
    }
};
