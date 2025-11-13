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
        Schema::create('column_countdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_column_id')->nullable()->constrained('section_columns')->onDelete('cascade');
            $table->foreignId('bg_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('title_arabic')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('button_value')->nullable();
            $table->string('button_value_arabic')->nullable();
            $table->foreignId('button_shape_id')->nullable()->constrained('shapes')->onDelete('cascade');
            $table->string('button_link')->nullable();
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
        Schema::dropIfExists('column_countdowns');
    }
};
