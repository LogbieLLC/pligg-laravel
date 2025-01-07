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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['enable', 'disable'])->default('enable');
            $table->integer('members_count')->default(0);
            $table->string('safename')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('privacy', ['private', 'public', 'restricted'])->default('public');
            $table->string('avatar')->nullable();
            $table->integer('vote_to_publish')->default(0);
            $table->string('field1')->default('');
            $table->string('field2')->default('');
            $table->string('field3')->default('');
            $table->string('field4')->default('');
            $table->string('field5')->default('');
            $table->string('field6')->default('');
            $table->boolean('notify_email')->default(false);
            $table->timestamps();

            $table->index('name');
            $table->index(['creator_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
