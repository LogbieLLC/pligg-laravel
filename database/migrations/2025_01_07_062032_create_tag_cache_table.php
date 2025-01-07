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
        Schema::create('tag_cache', function (Blueprint $table) {
            $table->string('tag_words', 64);
            $table->integer('count')->default(0);
            $table->timestamps();

            $table->primary('tag_words');
            $table->index('count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_cache');
    }
};
