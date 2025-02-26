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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable(false);
            $table->string('number')->nullable(false)->default('0'); // numero de cuenta, en caso de efectivo u otros tipos de cuentas es 0
            $table->integer('type_id')->nullable(false);
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 20, 4)->nullable(false);
            $table->string('description')->nullable();
            $table->smallInteger('status');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_unicode_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
