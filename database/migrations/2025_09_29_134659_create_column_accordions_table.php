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
        Schema::create('column_accordions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_column_id')->nullable()->constrained('section_columns')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('title_arabic')->nullable();
            $table->text('text_arabic')->nullable();
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
        Schema::dropIfExists('column_accordions');
    }
};
