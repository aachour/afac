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
            $table->text('image_featured')->nullable();
            $table->text('image_full')->nullable();
            $table->integer('image_width')->nullable();
            $table->foreignId('background_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->text('button_value')->nullable();
            $table->text('button_value_arabic')->nullable();
            $table->foreignId('button_shape_id')->nullable()->constrained('shapes')->onDelete('cascade');
            $table->foreignId('button_hover_shape_id')->nullable()->constrained('shapes')->onDelete('cascade');
            $table->text('button_link')->nullable();
            
            //Event Fields
            $table->foreignId('event_category_id')->nullable()->constrained('event_categories')->onDelete('cascade');
            $table->text('event_title')->nullable();
            $table->text('event_title_arabic')->nullable();
            $table->text('event_text')->nullable();
            $table->text('event_text_arabic')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_start_time')->nullable();
            $table->time('event_end_time')->nullable();
            $table->boolean('event_calendar_view')->nullable();

            //Program Fields
            $table->text('program_title')->nullable();
            $table->text('program_title_arabic')->nullable();
            $table->text('program_text')->nullable();
            $table->text('program_text_arabic')->nullable();
            $table->integer('program_status')->nullable();

            //Project Fields
            $table->foreignId('project_category_id')->nullable()->constrained('project_categories')->onDelete('cascade');
            $table->text('project_title')->nullable();
            $table->text('project_title_arabic')->nullable();  
            $table->text('project_text')->nullable();
            $table->text('project_text_arabic')->nullable();  
            $table->json('project_countries_id')->nullable();
            
            //Grantee Fields
            $table->text('grantee_name')->nullable();
            $table->text('grantee_name_arabic')->nullable();
            $table->text('grantee_text')->nullable();
            $table->text('grantee_text_arabic')->nullable();  
            $table->foreignId('grantee_country_id')->nullable()->constrained('countries')->onDelete('cascade'); 

            //Jury Fields
            $table->text('jury_name')->nullable();
            $table->text('jury_name_arabic')->nullable();  
            $table->text('jury_text')->nullable();
            $table->text('jury_text_arabic')->nullable();  
            $table->foreignId('jury_country_id')->nullable()->constrained('countries')->onDelete('cascade'); 

            //Resource Fields
            $table->text('resource_title')->nullable();
            $table->text('resource_title_arabic')->nullable();  
            $table->text('resource_text')->nullable(); 
            $table->text('resource_text_arabic')->nullable(); 
            $table->date('resource_date')->nullable(); 
            $table->text('resource_tags')->nullable(); 
            $table->text('resource_tags_arabic')->nullable(); 
            

            //News Fields
            $table->text('news_title')->nullable();
            $table->text('news_title_arabic')->nullable();  
            $table->text('news_text')->nullable(); 
            $table->text('news_text_arabic')->nullable(); 
            $table->date('news_date')->nullable(); 
            $table->text('news_tags')->nullable(); 
            $table->text('news_tags_arabic')->nullable(); 


            //External Fields
            $table->foreignId('external_category_id')->nullable()->constrained('external_categories')->onDelete('cascade');
            $table->text('external_title')->nullable();
            $table->text('external_title_arabic')->nullable();  
            $table->text('external_link')->nullable();
            

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
