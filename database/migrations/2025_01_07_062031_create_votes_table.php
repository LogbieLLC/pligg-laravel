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
        Schema::dropIfExists('votes');
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['links', 'comments'])->default('links');
            $table->foreignId('link_id')->constrained('links')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->smallInteger('value')->default(1);
            $table->integer('karma')->nullable();
            $table->string('ip', 64)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('link_id');
            $table->index(['type', 'link_id', 'user_id', 'ip']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
