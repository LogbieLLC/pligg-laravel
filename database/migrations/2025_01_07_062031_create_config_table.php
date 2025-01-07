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
        Schema::dropIfExists('config');
        Schema::create('config', function (Blueprint $table) {
            $table->string('var_id', 32)->primary();
            $table->string('var_page', 50);
            $table->string('var_name', 100);
            $table->string('var_value', 255)->nullable();
            $table->string('var_defaultvalue', 255)->nullable();
            $table->string('var_optiontext', 200)->nullable();
            $table->string('var_title', 200);
            $table->text('var_desc')->nullable();
            $table->string('var_method', 10);
            $table->boolean('var_enclosein')->default(false);
            $table->timestamps();

            $table->index('var_page');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config');
    }
};
