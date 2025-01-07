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
        Schema::create('tags', function (Blueprint $table) {
            $table->foreignId('link_id')->constrained('links')->onDelete('cascade');
            $table->string('lang', 4)->default('en');
            $table->string('words', 64);
            $table->timestamps();
            
            // Create composite primary key
            $table->primary(['link_id', 'lang', 'words']);

            $table->unique(['link_id', 'lang', 'words']);
            $table->index(['lang', 'created_at']);
            $table->index(['words', 'link_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
