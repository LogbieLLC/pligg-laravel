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
        Schema::dropIfExists('comments');
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('randkey');
            $table->foreignId('parent_id')->nullable()->references('id')->on('comments')->onDelete('cascade');
            $table->foreignId('link_id')->constrained('links')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('karma', 8, 2)->default(0.00);
            $table->text('content');
            $table->integer('votes')->default(0);
            $table->enum('status', ['discard', 'moderated', 'published', 'spam'])->default('published');
            $table->timestamps();

            $table->unique(['randkey', 'link_id', 'user_id', 'parent_id']);
            $table->index(['link_id', 'parent_id', 'created_at']);
            $table->index(['link_id', 'created_at']);
            $table->index('created_at');
            $table->index(['parent_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
