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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->nullable()->constrained('types')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('name_arabic')->nullable();
            $table->text('description')->nullable();
            $table->text('description_arabic')->nullable();
            $table->integer('description_position')->nullable();
            $table->foreignId('background_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->integer('with_filters')->nullable();
            $table->json('filter_fields')->nullable();
            $table->integer('entries_selection')->nullable();
            $table->integer('entries_number')->nullable();
            $table->integer('entries_with_expired')->nullable();
            $table->integer('entries_order')->nullable();
            $table->integer('title_position')->nullable();
            $table->integer('with_label')->nullable();
            $table->integer('entries_layout')->nullable();
            $table->integer('entries_per_row')->nullable();
            $table->integer('with_featured_image')->nullable();
            $table->integer('featured_image_width')->nullable();
            $table->foreignId('featured_image_background_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->text('featured_image_text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
