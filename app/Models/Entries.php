<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entries extends Model
{
    //

    use SoftDeletes;

    protected $guarded = [];

    public function type()
    {
        return $this->hasOne(Types::class, 'id', 'type_id');
    }

    public function headerBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'header_color_id');
    }

    public function footerBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'footer_color_id');
    }

    public function ImageBgColor()
    {
        return $this->hasOne(Colors::class, 'id', 'background_color_id');
    }

    public function eventCategory()
    {
        return $this->hasOne(EventCategories::class, 'id', 'event_category_id');
    }
    
    public function programYears()
    {
        return $this->hasOne(ProgramYearProjects::class, 'id', 'project_program_year_id');
    }

    public function projectCategories(array $ids)
    {
        if (app()->getLocale() == 'en') 
        {
            return ProjectCategories::whereIn(
                'id',
                $ids ?? []
            )->pluck('name');
        }else
        {
            return ProjectCategories::whereIn(
                'id',
                $ids ?? []
            )->pluck('name_arabic');
        }
    }

    public function projectCategoriesName(array $ids)
    {
        if (app()->getLocale() == 'en') 
        {
            return ProjectCategories::whereIn(
                'id',
                $ids ?? []
            )->pluck('name');
        } else 
        {
            return ProjectCategories::whereIn(
                'id',
                $ids ?? []
            )->pluck('name_arabic');
        }
    }

    public function projectCountries(array|string|null $ids)
    {
        if (empty($ids)) {
            return collect(); // or [] if you prefer array
        }

        // convert string → array
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        
        if (app()->getLocale() == 'en') 
        {
            return Countries::whereIn(
                'id',
                    $ids ?? []
                )->pluck('name');
        } else 
        {
            return Countries::whereIn(
            'id',
                $ids ?? []
            )->pluck('name_arabic');
        }
    }


    public function projectGrantees($id)
    {
        $projectGrantees=ProjectGrantees::where('project_id',$id)->pluck('grantee_id');
        $grantees=[];
        foreach($projectGrantees as $projectGranteeId){
            $grantee=Entries::find($projectGranteeId);
            if($grantee){
                $obj=[
                    'id'=>$grantee->id,
                    'name'=>$grantee->grantee_name,
                    'name_arabic'=>$grantee->grantee_name_arabic,
                ];
                $grantees[]=$obj;
            }
        }

        return $grantees;
    }


    public function projectProgram($id)
    {
        $projectProgram=ProgramYearProjects::find($id);

        return app()->getLocale() == 'en' ? $projectProgram?->programYear?->program->program_title : $projectProgram?->programYear?->program->program_title_arabic;
    }

    public function projectProgramYear($id)
    {
        $projectProgramYear=ProgramYearProjects::find($id);

        return $projectProgramYear?->programYear?->year;
    }


    public function granteeCategories(array $ids)
    {
        if (app()->getLocale() == 'en') 
        {
            return GranteeCategories::whereIn(
                'id',
                    $ids ?? []
                )->pluck('name');
        } else 
        {
            return GranteeCategories::whereIn(
            'id',
                $ids ?? []
            )->pluck('name_arabic');
        }
    }

    public function granteeCountry()
    {
        return $this->hasOne(Countries::class, 'id', 'grantee_country_id');
    }

    public function juryCountry()
    {
        return $this->hasOne(Countries::class, 'id', 'jury_country_id');
    }

    public function resourceCategory()
    {
        return $this->hasOne(ResourceCategories::class, 'id', 'resource_category_id');
    }
    
    public function externalCategory()
    {
        return $this->hasOne(ExternalCategories::class, 'id', 'external_category_id');
    }

    public function newsCategory()
    {
        return $this->hasOne(NewsCategories::class, 'id', 'news_category_id');
    }

}
