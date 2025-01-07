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
        Schema::dropIfExists('login_attempts');
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100)->nullable();
            $table->string('ip', 100)->nullable();
            $table->integer('count')->default(0);
            $table->timestamps();

            $table->unique(['ip', 'username']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_attempts');
    }
};
