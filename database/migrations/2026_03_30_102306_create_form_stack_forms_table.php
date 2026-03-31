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
        Schema::create('form_stack_forms', function (Blueprint $table) {
            $table->id();
            $table->char('form_id', 36)->unique();
            $table->text('form_name')->nullable();
            $table->text('form_lang')->nullable();
            $table->text('form_submissions')->nullable();
            $table->text('form_is_workflow_form')->nullable();
            $table->text('form_is_workflow_published')->nullable();
            $table->dateTime('form_created_at')->nullable();
            $table->dateTime('form_updated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_stack_forms');
    }
};
