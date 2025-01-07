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
        Schema::dropIfExists('widgets');
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->decimal('version', 3, 1);
            $table->decimal('latest_version', 3, 1)->default(0);
            $table->string('folder', 50)->unique();
            $table->boolean('enabled')->default(true);
            $table->enum('column', ['left', 'right'])->default('left');
            $table->integer('position')->default(0);
            $table->string('display', 5)->default('');
            $table->timestamps();

            $table->index('folder');
            $table->index(['enabled', 'column', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
