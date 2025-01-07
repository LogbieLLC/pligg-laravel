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
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login', 32)->unique();
            $table->enum('level', ['normal', 'moderator', 'admin', 'spammer'])->default('normal');
            $table->string('password', 64);
            $table->string('email', 128)->unique();
            $table->string('name', 128);
            $table->decimal('karma', 10, 2)->default(0.00);
            $table->string('url', 128)->nullable();
            $table->string('facebook', 64)->nullable();
            $table->string('twitter', 64)->nullable();
            $table->string('linkedin', 64)->nullable();
            $table->string('googleplus', 64)->nullable();
            $table->string('skype', 64)->nullable();
            $table->string('pinterest', 64)->nullable();
            $table->string('public_email', 64)->nullable();
            $table->string('avatar_source')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('last_ip', 45)->nullable();
            $table->timestamp('last_reset_request')->nullable();
            $table->string('reset_code')->nullable();
            $table->string('location')->nullable();
            $table->string('occupation')->nullable();
            $table->string('categories')->default('');
            $table->boolean('enabled')->default(true);
            $table->string('language', 32)->nullable();
            $table->rememberToken(); // For Laravel's "remember me" functionality
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();

            $table->index('email');
            $table->index('karma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
