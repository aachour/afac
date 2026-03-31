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
            $table->char('form_id', 36)->nullable();
            $table->text('submission_id')->nullable();
            $table->text('email')->nullable();
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
