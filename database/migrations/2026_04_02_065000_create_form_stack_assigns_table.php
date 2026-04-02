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
        Schema::create('form_stack_assigns', function (Blueprint $table) {
            $table->string('form_id');
            $table->string('submission_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->float('grade')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('form_id')
                ->references('form_id')
                ->on('form_stack_forms')
                ->onDelete('cascade');

            $table->foreign('submission_id')
                ->references('submission_id')
                ->on('form_stack_submissions')
                ->onDelete('cascade');

            $table->unique(['user_id', 'form_id', 'submission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_stack_assigns');
    }
};
