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
        Schema::create('column_timeline_percentages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timeline_id')->nullable()->constrained('column_timelines')->onDelete('cascade');
            $table->text('text')->nullable();
            $table->text('text_arabic')->nullable();
            $table->foreignId('shape_id')->nullable()->constrained('shapes')->onDelete('cascade');
            $table->integer('percentage')->nullable();
            $table->foreignId('percentage_color_id')->nullable()->constrained('colors')->onDelete('cascade');
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
        Schema::dropIfExists('column_timeline_percentages');
    }
};
