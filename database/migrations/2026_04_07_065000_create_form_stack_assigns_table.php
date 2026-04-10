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
            $table->id();
            $table->foreignId('group_id')->constrained('form_stack_groups')->onDelete('cascade');
            $table->string('form_id');
            $table->string('submission_id');
            $table->foreignId('juror_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('reader_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('form_type')->nullable();
            $table->string('form_status')->nullable();
            $table->integer('form_rate1')->nullable();
            $table->integer('form_rate2')->nullable();
            $table->integer('form_rate3')->nullable();
            $table->integer('form_rate4')->nullable();
            $table->text('form_notes')->nullable();
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

            $table->unique(
                ['group_id', 'juror_id', 'form_id', 'submission_id'],
                'uq_fsa_juror'
            );

            $table->unique(
                ['group_id', 'reader_id', 'form_id', 'submission_id'],
                'uq_fsa_reader'
            );
            
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
