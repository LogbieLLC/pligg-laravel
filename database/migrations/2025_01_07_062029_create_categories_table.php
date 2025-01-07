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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('lang', 5)->default('en');
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('name', 64);
            $table->string('safe_name', 64);
            $table->integer('rgt')->default(0);
            $table->integer('lft')->default(0);
            $table->boolean('enabled')->default(true);
            $table->integer('order')->default(0);
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->enum('author_level', ['normal', 'moderator', 'admin'])->default('normal');
            $table->string('author_group')->default('');
            $table->string('votes', 4)->default('');
            $table->string('karma', 4)->default('');
            $table->timestamps();

            $table->index('parent_id');
            $table->index('safe_name');
            $table->index(['enabled', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
