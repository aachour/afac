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
        Schema::create('column_patterns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_column_id')->nullable()->constrained('section_columns')->onDelete('cascade');
            $table->foreignId('button_shape_id')->nullable()->constrained('shapes')->onDelete('cascade');
            $table->foreignId('button_hover_shape_id')->nullable()->constrained('shapes')->onDelete('cascade');
            $table->foreignId('button_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->foreignId('button_hover_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->foreignId('button_bg_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->foreignId('button_hover_bg_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->text('button_text')->nullable();
            $table->text('button_text_arabic')->nullable();
            $table->text('button_link')->nullable();
            $table->text('button_link_arabic')->nullable();
            $table->integer('with_animation')->nullable();
            $table->integer('list_order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('column_patterns');
    }
};
