<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->integer('list_order')->nullable()->after('published');
        });

        // Initialize list_order based on existing id order
        DB::statement('UPDATE pages SET list_order = id WHERE deleted_at IS NULL');
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('list_order');
        });
    }
};
