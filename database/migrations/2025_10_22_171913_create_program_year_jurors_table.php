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
        Schema::create('program_year_jurors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_year_id')->nullable()->constrained('program_years')->onDelete('cascade');
            $table->foreignId('juror_id')->nullable()->constrained('entries')->onDelete('cascade');
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
        Schema::dropIfExists('program_year_jurors');
    }
};
