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
        Schema::create('entries', function (Blueprint $table) {
            
            $table->id();

            //Common Fields
            $table->foreignId('type_id')->nullable()->constrained('types')->onDelete('cascade');
            $table->text('image')->nullable();
            $table->integer('image_width')->nullable();
            $table->foreignId('background_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->text('button_link')->nullable();
            $table->text('button_value')->nullable();
            $table->text('button_value_arabic')->nullable();

            //Event Fields
            $table->foreignId('event_category_id')->nullable()->constrained('event_categories')->onDelete('cascade');
            $table->text('event_title')->nullable();
            $table->text('event_title_arabic')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_start_time')->nullable();
            $table->time('event_end_time')->nullable();

            //Program Fields
            $table->text('program_title')->nullable();
            $table->text('program_title_arabic')->nullable();
            $table->integer('program_status')->nullable();

            //Project Fields
            $table->foreignId('project_category_id')->nullable()->constrained('project_categories')->onDelete('cascade');
            $table->text('project_title')->nullable();
            $table->text('project_title_arabic')->nullable();        
            $table->foreignId('project_country_id')->nullable()->constrained('countries')->onDelete('cascade'); 
            $table->foreignId('project_program_year_id')->nullable()->constrained('program_years_project')->onDelete('cascade'); 
            
            
            //Grantee Fields
            $table->text('grantee_name')->nullable();
            $table->text('grantee_name_arabic')->nullable();
            $table->foreignId('grantee_country_id')->nullable()->constrained('countries')->onDelete('cascade'); 
            $table->text('grantee_image')->nullable(); 

            //Jury Fields
            $table->text('jury_name')->nullable();
            $table->text('jury_name_arabic')->nullable();  
            $table->text('jury_bio')->nullable();
            $table->text('jury_bio_arabic')->nullable();  
            $table->foreignId('jury_country_id')->nullable()->constrained('countries')->onDelete('cascade'); 
            $table->text('jury_image')->nullable(); 

            //Resource Fields
            $table->text('resource_title')->nullable();
            $table->text('resource_title_arabic')->nullable();  
            $table->date('resource_date')->nullable(); 
            $table->text('resource_tags')->nullable(); 
            $table->text('resource_tags_arabic')->nullable(); 

            //News Fields
            $table->text('news_title')->nullable();
            $table->text('news_title_arabic')->nullable();  
            $table->date('news_date')->nullable(); 
            $table->text('news_tags')->nullable(); 
            $table->text('news_tags_arabic')->nullable(); 

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
