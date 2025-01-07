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
        Schema::dropIfExists('links');
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['discard', 'new', 'published', 'abuse', 'duplicate', 'page', 'spam'])->default('new');
            $table->integer('randkey');
            $table->integer('votes')->default(0);
            $table->integer('reports')->default(0);
            $table->integer('comments')->default(0);
            $table->decimal('karma', 10, 2)->default(0.00);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->integer('lang_id')->default(1);
            $table->string('url', 200);
            $table->text('url_title')->nullable();
            $table->text('title');
            $table->string('title_url')->nullable();
            $table->mediumText('content');
            $table->text('summary')->nullable();
            $table->text('tags')->nullable();
            $table->string('field1')->default('');
            $table->string('field2')->default('');
            $table->string('field3')->default('');
            $table->string('field4')->default('');
            $table->string('field5')->default('');
            $table->string('field6')->default('');
            $table->string('field7')->default('');
            $table->string('field8')->default('');
            $table->string('field9')->default('');
            $table->string('field10')->default('');
            $table->string('field11')->default('');
            $table->string('field12')->default('');
            $table->string('field13')->default('');
            $table->string('field14')->default('');
            $table->string('field15')->default('');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('set null');
            $table->enum('group_status', ['new', 'published', 'discard'])->default('new');
            $table->integer('out_clicks')->default(0);
            $table->timestamps();

            $table->index('url');
            $table->index('status');
            $table->index('title_url');
            $table->index(['status', 'created_at']);
            $table->index(['status', 'published_at']);
            $table->fullText(['url', 'url_title', 'title', 'content', 'tags']);
            $table->fullText('tags');
            $table->fullText(['title', 'content', 'tags']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
