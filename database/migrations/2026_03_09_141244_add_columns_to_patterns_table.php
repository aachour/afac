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
        Schema::table('column_patterns', function (Blueprint $table) {
            //
            $table->text('text')->after('section_column_id')->nullable();
            $table->text('text_arabic')->after('text')->nullable();
            $table->integer('animation_style')->after('with_animation')->nullable();
        });
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patterns', function (Blueprint $table) {
            //
            $table->text('text')->nullable();
            $table->text('text_arabic')->nullable();
            $table->integer('animation_style')->nullable();
        });
    }
};
