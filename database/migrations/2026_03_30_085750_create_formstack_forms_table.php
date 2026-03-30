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
        Schema::create('formstack_forms', function (Blueprint $table) {
            $table->id();
            $table->text('form_id')->nullable();
            $table->text('form_name')->nullable();
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
        Schema::dropIfExists('formstack_forms');
    }
};
