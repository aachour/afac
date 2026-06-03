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
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('col1')->nullable();
            $table->json('col1_links')->nullable();
            $table->string('col1_arabic')->nullable();
            $table->json('col1_arabic_links')->nullable();
            $table->string('col2')->nullable();
            $table->json('col2_links')->nullable();
            $table->string('col2_arabic')->nullable();
            $table->json('col2_arabic_links')->nullable();
            $table->string('col3')->nullable();
            $table->json('col3_links')->nullable();
            $table->string('col3_arabic')->nullable();
            $table->json('col3_arabic_links')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
