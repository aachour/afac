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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_arabic')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_title_arabic')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_description_arabic')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_keywords_arabic')->nullable();
            $table->foreignId('header_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->foreignId('footer_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->integer('in_menu')->nullable();
            $table->integer('published')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
