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
        //
        Schema::table('column_patterns', function (Blueprint $table) {
            $table->dropForeign(['button_shape_id']);
            $table->dropForeign(['button_hover_shape_id']);
            $table->dropForeign(['button_color_id']);
            $table->dropForeign(['button_hover_color_id']);
            $table->dropForeign(['button_bg_color_id']);
            $table->dropForeign(['button_hover_bg_color_id']);

            $table->dropColumn([
                'button_shape_id',
                'button_hover_shape_id',
                'button_color_id',
                'button_hover_color_id',
                'button_bg_color_id',
                'button_hover_bg_color_id',
                'button_text',
                'button_text_arabic',
                'button_link',
                'button_link_arabic',
                'with_animation',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('column_patterns', function (Blueprint $table) {
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
        });
    }
};
