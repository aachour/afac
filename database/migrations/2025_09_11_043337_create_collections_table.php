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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->nullable()->constrained('types')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('description_position')->nullable();
            $table->foreignId('background_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->integer('with_filters')->nullable();
            $table->json('filter_fields')->nullable();
            $table->integer('custom_entries')->nullable();
            $table->integer('system_entries')->nullable();
            $table->integer('system_entries_number')->nullable();
            $table->integer('system_entries_expired')->nullable();
            $table->integer('system_entries_order')->nullable();
            
            
            
            

            $table->integer('with_featured_entry')->nullable();
            $table->integer('title_position')->nullable();
            $table->integer('with_label')->nullable();
            $table->integer('entries_layout')->nullable();
            
            
            
            
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->integer('published')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
