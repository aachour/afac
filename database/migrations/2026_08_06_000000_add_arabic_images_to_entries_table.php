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
        Schema::table('entries', function (Blueprint $table) {
            // Match existing image columns: text and nullable
            $table->text('image_featured_arabic')->nullable()->after('image_featured');
            $table->text('image_arabic')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn(['image_featured_arabic', 'image_arabic']);
        });
    }
};
