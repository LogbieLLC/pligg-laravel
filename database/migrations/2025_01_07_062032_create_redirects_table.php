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
        Schema::dropIfExists('redirects');
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('old_path', 255);
            $table->string('new_path', 255);
            $table->timestamps();

            $table->index('old_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redirects');
    }
};
