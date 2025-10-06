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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('event_categories')->onDelete('cascade');
            $table->text('title')->nullable();
            $table->text('title_arabic')->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('image')->nullable();
            $table->integer('image_width')->nullable();
            $table->foreignId('background_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->text('button_link')->nullable();
            $table->text('button_value')->nullable();
            $table->text('button_value_arabic')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
