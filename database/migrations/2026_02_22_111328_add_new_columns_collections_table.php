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
        Schema::table('collections', function (Blueprint $table) {
            $table->boolean('show_all_entries')->nullable()->after('entries_number');
            $table->foreignId('button_background_color_id')->after('button_text_arabic')->nullable()->constrained('colors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'birth_date', 'is_active']);
        });
    }
};
