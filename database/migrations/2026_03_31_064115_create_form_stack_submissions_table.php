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
        Schema::create('form_stack_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('form_id');
            $table->string('submission_id')->unique();
            $table->text('email')->nullable();
            $table->text('admin_id')->nullable();
            $table->text('admin_status')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('form_id')
                ->references('form_id')
                ->on('form_stack_forms')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_stack_submissions');
    }
};
