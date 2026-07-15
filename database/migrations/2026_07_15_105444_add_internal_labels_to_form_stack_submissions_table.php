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
        Schema::table('form_stack_submissions', function (Blueprint $table) {
            $table->json('admin_internal_labels')->nullable()->after('admin_notes');
            $table->json('pm_internal_labels')->nullable()->after('admin_internal_labels');
            $table->json('juror_internal_labels')->nullable()->after('pm_internal_labels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_stack_submissions', function (Blueprint $table) {
            $table->dropColumn(['admin_internal_labels', 'pm_internal_labels', 'juror_internal_labels']);
        });
    }
};
