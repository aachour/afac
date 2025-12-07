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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onDelete('cascade');
            $table->foreignId('entry_id')->nullable()->constrained('entries')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->foreignId('bg_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->text('bg_image')->nullable();
            $table->boolean('with_border_bottom')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
