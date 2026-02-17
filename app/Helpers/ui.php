<?php

    use App\Models\Collections;
    use App\Models\CollectionEntries;
    use App\Models\Entries;
    use App\Models\Sections;
    use App\Models\SectionColumns;
    use App\Models\ColumnGeneral;
    use App\Models\ColumnTimeline;
    use App\Models\ColumnAccordion;
    use App\Models\ColumnCountdown;
    use App\Models\ColumnExpandTexts;
use App\Models\GranteeCategories;
use App\Models\ProjectGrantees;
    use App\Models\ProgramYearProjects;
    use App\Models\ProgramYearJurors;
    
    use App\Models\Logo;
    use Carbon\Carbon;
            
    function ViewEntryData($entry_id,$language='EN')
    {

        $entry=Entries::find($entry_id);

        if($entry){
            
            //Get entry labels
            $labels=getEntryLabels($entry);

            $html='<div class="fullContainer">';
                
                $html.='<div class="centerContainer" style="background:'.$entry->ImageBgColor?->code.';">
                    <div class="row align-items-center">';
                        if($entry->type_id<=5)
                        {
                            $html.='<div class="col-lg-6 col-12 text-center">
                                <div class="labels">';
                                    $html.='<div class="label micro black ABCDiatypeMedium">'.$entry->type->name.'</div>';
                                    foreach($labels as $label){
                                        $html.='<div class="label micro rounded">'.$label.'</div>';
                                    }
                                $html.='</div>
                                <div class="mt-3 huge black ABCDiatypeMedium">'.getEntryTitle($entry).'</div>';
                                if($entry->type_id==3) //get grantees
                                {
                                    foreach($entry->projectGrantees($entry->id) as $grantee){
                                        $html.='<div class="mt-3">
                                            <a href="'.route('entry.view', ['entryType'=>'grantee','id'=>$grantee["id"]]).'" class="small black ABCDiatypeMedium">'.$grantee["name"].'</a>
                                        </div>';
                                    }
                                }
                            $html.='</div>
                            <div class="col-lg-6 col-12">';
                                if($entry->image_featured){
                                    $html.='<img src="'.asset('storage/'.$entry->image_featured).'" width="100%" />';
                                }else{
                                    $html.='<img src="'.asset('frontend/images/default-image-featured.png').'" width="100%" />';
                                }
                            $html.='</div>';
                        }
                        else
                        { // Resourses/News/Externals
                            $html.='<div class="col-12 text-center">';

                                $html.='<div class="big black ABCDiatypeMedium text-start">'.getEntryTitle($entry).'</div>';

                                $html.='<div class="mt-2 mb-3 medium black ABCDiatypeMedium text-start">';
                                    if($entry->type_id==6){$html.=date('d M Y',strtotime($entry->resource_date));}
                                    else if($entry->type_id==7){$html.=date('d M Y',strtotime($entry->news_date));}
                                $html.='</div>';

                                if($entry->image_featured){
                                    $html.='<img src="'.asset('storage/'.$entry->image_full).'" width="100%" />';
                                }else{
                                    $html.='<img src="'.asset('frontend/images/default-image-full.png').'" width="100%" />';
                                }
                                $html.='<div class="mt-2 micro black text-start">'.$entry->image_caption.'</div>
                            </div>';

                        }
                    $html.='</div>
                </div>';
                
            $html.='</div>';

            //show at a glance for Supported Project & Grantee. 
            if($entry->type_id==3 || $entry->type_id==4 || $entry->type_id==5){
                $html.='<div class="fullContainer mt-5">
                    <div class="centerContainer">
                        <div class="row">

                            <div class="col-lg-6 col-12">
                                <div class="big black ABCDiatypeMedium">At-A-Glance</div>
                            </div>

                            <div class="col-lg-6 col-12">';
                                if($entry->type_id==3){ //Supported Project
                                    $html.='<div class="mt-1 tiny black ABCDiatypeBlack">Program</div>';
                                    $html.='<div class="mt-1"><a href="'.route('entry.view', ['entryType'=>'program','id'=>$entry->programYears?->programYear?->program?->id]).'" class="medium black ABCDiatypeMedium">'.$entry->programYears?->programYear?->program?->program_title.'</a></div>';

                                    $html.='<div class="mt-5 tiny black ABCDiatypeBlack">Theme</div>';
                                    $categories=$entry->projectCategories(json_decode($entry->project_categories_id, true) ?? []);
                                    foreach($categories as $category){
                                        $html.='<div class="mt-1 medium black ABCDiatypeMedium">'.$category.'</div>';
                                    }

                                }
                                else if($entry->type_id==4){ //Grantee

                                    $html.='<div class="mt-1 tiny black ABCDiatypeBlack">Projects</div>';
                                    $projectGrantees=ProjectGrantees::WHERE('grantee_id',$entry->id)->get();
                                    foreach($projectGrantees as $projectGrantee){
                                        $html.='<div class="mt-1"><a href="'.route('entry.view', ['entryType'=>'project','id'=>$projectGrantee->project->id]).'" class="medium black ABCDiatypeMedium">'.$projectGrantee->project?->project_title.'</a></div>';
                                    }

                                    $html.='<div class="mt-5 tiny black ABCDiatypeBlack">Theme</div>';
                                    $categories=$entry->granteeCategories(json_decode($entry->grantee_categories_id, true) ?? []);
                                    foreach($categories as $category){
                                        $html.='<div class="mt-1 medium black ABCDiatypeMedium">'.$category.'</div>';
                                    }

                                    $html.='<div class="mt-5 tiny black ABCDiatypeBlack">Biography</div>';
                                    $html.='<div class="mt-1 smnall black">'.nl2br($entry->grantee_text, false).'</div>';
                                }
                                else if($entry->type_id==5){ //Juror
                                    $html.='<div class="mt-1 tiny black ABCDiatypeBlack">Biography</div>';
                                    $html.='<div class="mt-1 smnall black">'.nl2br($entry->jury_text, false).'</div>';
                                }
                            
                            $html.='</div>
                        </div>
                    </div>
                </div>';
            }
            

            return $html;

        }
 
    }


    function ViewCollection($collection_id,$language='EN')
    {

        $collection=Collections::find($collection_id);

        if($collection==null){
            return '';
        }

        $html='';

        $collection_type_id=$collection->type_id;
        $with_filters=$collection->with_filters;
        $entries_selection=$collection->entries_selection;

        //Set Filters
        if($with_filters==1){   

            $entries=[];

            if ($entries_selection == 1) // custom selection
            {
                $collectionEntries = CollectionEntries::where('collection_id', $collection_id)
                        ->with('entry')
                        ->orderBy('list_order', 'ASC')
                        ->get();
                
                //extract entries from collection
                if(count($collectionEntries)>0){
                    foreach($collectionEntries as $collectionEntry){
                        $entries[]=$collectionEntry->entry;
                    }
                }
            }
            else if ($entries_selection == 2) // system selection
            {
                $entries_number   = $collection->entries_number;
                $entries_expired  = $collection->entries_with_expired;
                $entries_order    = $collection->entries_order;

                $query = Entries::where(['type_id' => $collection_type_id , 'published' => '1']);

                // Filter expired only for events
                // if ($entries_expired == 1 && $collection_type_id == 1) {
                //     $query->where('event_start_date', '>=', date('Y-m-d'));
                // }

                // When type is project, check program and year
                if($collection_type_id == 3 && $collection->entries_program_year_id!=null)
                {
                    $entries_program_year_id=$collection->entries_program_year_id;

                    $projectIds = ProgramYearProjects::where('program_year_id', $entries_program_year_id)
                        ->pluck('project_id')
                        ->toArray();

                    $query->whereIn('id', $projectIds);
                }

                // When type is grantee, check program and year
                if($collection_type_id == 4 && $collection->entries_program_year_id!=null)
                {
                    $entries_program_year_id=$collection->entries_program_year_id;

                    //get projects
                    $projectIds = ProgramYearProjects::where('program_year_id', $entries_program_year_id)
                        ->pluck('project_id')
                        ->toArray();

                    //get grantees
                    $granteeIds=ProjectGrantees::WHEREIN('project_id',$projectIds)->pluck('grantee_id')
                        ->toArray();

                    $query->whereIn('id', $granteeIds);
                }

                // When type is juror, check program and year
                if($collection_type_id == 5 && $collection->entries_program_year_id!=null)
                {
                    $entries_program_year_id=$collection->entries_program_year_id;

                    $jurorIds = ProgramYearJurors::where('program_year_id', $entries_program_year_id)
                        ->pluck('juror_id')
                        ->toArray();

                    $query->whereIn('id', $jurorIds);
                }

                // Ordering 
                if ($collection_type_id == 1 && $entries_order == 1) //event name asc
                {
                    $query->orderBy('event_title', 'asc');
                } 
                else if ($collection_type_id == 1 && $entries_order == 2)  //event name desc
                {
                    $query->orderBy('event_title', 'desc');
                } 
                else if ($entries_order == 3) //id asc
                {
                    $query->orderBy('id', 'asc');
                } 
                else if ($entries_order == 4) //id desc
                {
                    $query->orderBy('id', 'desc');
                }

                // Limit & get results
                $entries = $query->limit($entries_number)->get();
            }

            $html.=setCollectionFilters($collection_id,$collection_type_id,$entries);
            if (!blank($collection->background_color_id)){$html.='<div class="mt-4"></div>';}
        }


        $html.='<div id="collectionEntries-'.$collection_id.'"></div>';
        $html.='<div class="mt-5 text-center d-none" id="loader"><div class="loader"></div></div>';

        $html.='<script>

            function getEntries(filters=""){
                let collection_id= '.$collection_id.'; 
                $("#collectionEntries-'.$collection_id.'").empty();
                $("#loader").removeClass("d-none");
                $.ajax({
                    url: "' . route('get.entries') . '",
                    method: "POST",
                    data: {
                        collection_id: collection_id,
                        filters: filters,
                        
                    },
                    success: function(response) {
                        $("#loader").addClass("d-none");
                        $("#collectionEntries-'.$collection_id.'").html(response);
                    },
                    error: function(xhr) {
                        if(xhr.responseJSON && xhr.responseJSON.errors){
                            alert(JSON.stringify(xhr.responseJSON.errors));
                        }
                    }
                });
            }

            $(document).ready(function(){ 

                getEntries();
                
            });

        </script>';
        
        return $html;

    }   


    function ViewSection($section_id,$language='EN')
    {

        $section = Sections::with('columns')->find($section_id);

        if($section){

            $sectionColumns= $section->columns;

            $colsNum=count($sectionColumns);

            $bgColor=$section->bgColor->code ?? '';
            $bgImage=$section->bg_image;

            $sectionBg='';
            if($bgImage!=''){ 
                $sectionBg = "background: url('".asset("storage/$bgImage")."') center no-repeat; background-size: cover;";
            }else if($bgColor!=''){
                $sectionBg="background:".$bgColor.";";
            }

            $html='<div class="section" style="'.$sectionBg.'">

                <div class="row">';

                    foreach($sectionColumns as $sectionColumn){
                        
                        $html .= '<div class="col-lg-' . ($colsNum == 1 ? '12' : '6') . ' col-12">';

                        $colType=$sectionColumn->type_id;
                        
                        if($colType==1) //Get general inputs
                        {
                            $html.=ViewColumnGeneral($sectionColumn->id,"En");
                        }
                        else if($colType==2) //Get timeline
                        {
                            $html.=ViewTimeline($sectionColumn->id,"En");
                        }
                        else if($colType==3) //Get accordion
                        {
                            $html.=ViewAccordion($sectionColumn->id,"En");
                        }
                        else if($colType==4) //Get countdown
                        {
                            $html.=ViewCountdown($sectionColumn->id,"En");
                        }
                        else if($colType==5) //Get expanding text
                        {
                            $html.=ViewExpandingText($sectionColumn->id,"En");
                        }

                        $html.='</div>';

                    }

                $html.='</div>

            </div>';

            if($section->with_border_bottom==1){
                $html.='<div class="sectionWithBorder"></div>';
            }

            return $html;

        }


    }


    function ViewColumnGeneral($section_column_id,$language='EN')
    {

        $htmlColumn='';

        $column=SectionColumns::with('generalInputs')->find($section_column_id);

        if($column){

            $textAlign = $column->alignment_id == 1 ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');

            $htmlColumn.='<div class="row '.$textAlign.'">';

                if($column->width == 1){
                $htmlColumn.='<div class="col-lg-12 col-12">';
                }elseif($column->width == 2){
                $htmlColumn.='<div class="col-lg-9 col-12">';
                }elseif($column->width == 3){
                $htmlColumn.='<div class="col-lg-3"></div><div class="col-lg-6 col-12">';
                }

                foreach($column->generalInputs as $generalInput){

                    $input_type_id=$generalInput->input_type_id;

                    if($input_type_id==1)
                    {   //title
                        $htmlColumn.='<div class="topSpacerSmall big black ABCDiatypeMedium">'.$generalInput->title.'</div>';
                    }
                    else if($input_type_id==2)
                    {   //text
                        $htmlColumn.='<div class="topSpacer small black ABCDiatype">'.$generalInput->text.'</div>';
                    }
                    else if($input_type_id==3)
                    {   //gallery
                        $galleryImages=$generalInput->gallery->images;
                        if(count($galleryImages)==1){ //single image
                            $htmlColumn.='<div class="topSpacer"><img src='.asset("storage/".$galleryImages[0]->image_path).' /></div>';
                            $htmlColumn.='<div class="topSpacerSmaller tiny black">'.$galleryImages[0]->caption.'</div>';
                        }
                        else{ //gallery images
                            foreach($galleryImages as $galleryImage){
                                $htmlColumn.='<div class="topSpacer"><img src='.asset("storage/".$galleryImage->image_path).' width="100%" /></div>';
                                break;
                            }
                        }
                    }
                    else if($input_type_id==4)
                    {   //video
                        $htmlColumn.='<div class="topSpacer"><iframe src="'.$generalInput->video.'" width="100%" height="400px"></iframe></div>';
                    }
                    else if($input_type_id==5)
                    {   //button

                        $textAlign = $generalInput->button_link == null ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');
                        
                        $htmlColumn.='<div class="topSpacerBig">
                        
                            <a href="' . ($generalInput->button_link ?? '#') . '">'.getEntryBtnShape($generalInput->button_value,$generalInput->button_value_arabic,$generalInput->shape?->name,$generalInput->shapeHover->name,$generalInput->buttonColor->code,$generalInput->buttonHoverColor->code,$generalInput->buttonBgColor->code,$generalInput->buttonHoverBgColor->code).'</a>
                        </div>';
                    }

                }

                $htmlColumn.='</div>

            </div>';

        }

        return $htmlColumn;

    }


    function ViewTimeline($section_column_id,$language='EN')
    {

        $htmlColumn='';

        $column=SectionColumns::with('timelines.percentages.color')->find($section_column_id);

        if($column){

            $textAlign = $column->alignment_id == 1 ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');

            $htmlColumn.='<div class="timelines '.$textAlign.'">

                <div class="row">';

                    if($column->width == 1){
                    $htmlColumn.='<div class="col-lg-12 col-12">';
                    }elseif($column->width == 2){
                    $htmlColumn.='<div class="col-lg-9 col-12">';
                    }elseif($column->width == 3){
                    $htmlColumn.='<div class="col-lg-3"></div><div class="col-lg-6 col-12">';
                    }

                        foreach($column->timelines as $timeline){

                            $htmlColumn.= '<div class="timeline mb-5">
                                <div class="row">
                                    <div class="col-lg-3 col-12">
                                        <div class="black big ABCDiatypeMedium mb-2">
                                            <img src="'.asset('frontend/images/diamond.png').'" width="40px" />&nbsp;&nbsp;
                                            '.$timeline->date.'
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-12">
                                        <div class="timeline-percentages-wrapper">';

                                       
                                        $percentageIndex = 0;
                                        foreach($timeline->percentages as $key=>$percentage){
                                            $uniqueId = 'timeline-'.$timeline->id.'-percentage-'.$percentageIndex;
                                            $percentageColor = $percentage->color->code ?? '#010101';
                                            $percentageValue = $percentage->percentage ?? 0;
                                            
                                            $htmlColumn.='<div class="percentage-column '.($percentageIndex == 0 ? 'active' : 'd-none').'" 
                                                data-percentage-id="'.$uniqueId.'" 
                                                data-percentage-value="'.$percentageValue.'" 
                                                data-percentage-color="'.$percentageColor.'"
                                                data-timeline-id="'.$timeline->id.'">

                                                <div class="percentage-text big black mb-5">'.$percentage->text.'</div>'; 
                                                
                                                if($percentage->percentage!=0){
                                                    $diamondCount = 0;
                                                    $totalDiamonds = 100;
                                                    $coloredDiamonds = min($percentageValue, $totalDiamonds);
                                                    
                                                    $htmlColumn.='<div class="diamonds-grid" data-percentage-color="'.$percentageColor.'">';
                                                    for($i=1;$i<=10;$i++){
                                                        for($j=1;$j<=10;$j++){
                                                            $diamondCount++;
                                                            $isColored = $diamondCount <= $coloredDiamonds;
                                                            $diamondClass = $isColored ? 'diamond-colored' : 'diamond-default';
                                                            $diamondFillColor = $isColored ? $percentageColor : '#010101';
                                                            
                                                            $htmlColumn.='<span class="diamond-wrapper">
                                                                <svg width="100%" height="100%" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg" 
                                                                    class="diamond-percentage '.$diamondClass.'" 
                                                                    data-diamond-index="'.$diamondCount.'"
                                                                    data-is-colored="'.($isColored ? '1' : '0').'"
                                                                    data-diamond-color="'.$diamondFillColor.'">
                                                                    <rect y="153.999" width="217.787" height="217.787" transform="rotate(-45 0 153.999)" fill="'.$diamondFillColor.'"/>
                                                                </svg>
                                                            </span>';
                                                        }  
                                                        $htmlColumn.='<br />';
                                                    }
                                                    $htmlColumn.='</div>';
                                                }
                                            
                                            $htmlColumn.='</div>';
                                            $percentageIndex++;
                                        }
                                        
                                        $htmlColumn.='</div>';
                                    
                                    $htmlColumn.='</div>
                                </div>
                            </div>';

                        }

                        $htmlColumn.='<div class="verticalLine"></div>

                    </div>

                </div>

            </div>';

            $htmlColumn.='<style>
                
            </style>
            <script>
                (function() {
                    document.addEventListener("DOMContentLoaded", function() {
                        
                        const timelineWrappers = document.querySelectorAll(".timeline-percentages-wrapper");
                        
                        timelineWrappers.forEach(function(wrapper) {
                            const percentageColumns = wrapper.querySelectorAll(".percentage-column");
                            
                            if (percentageColumns.length <= 1) return; 
                            
                            let currentIndex = 0;
                            
                            function resetDiamondsToBlack(column) {
                                const allDiamonds = column.querySelectorAll(".diamond-percentage rect");
                                allDiamonds.forEach(function(rect) {
                                    rect.setAttribute("fill", "#010101");
                                });
                            }
                            
                            function lightUpDiamondsSequentially(column) {
                                const diamondsGrid = column.querySelector(".diamonds-grid");
                                if (!diamondsGrid) return;
                                
                                const color = diamondsGrid.getAttribute("data-percentage-color") || "#010101";
                                const coloredDiamonds = column.querySelectorAll(".diamond-percentage[data-is-colored=\"1\"]");
                                const defaultDiamonds = column.querySelectorAll(".diamond-percentage[data-is-colored=\"0\"]");
                                
                                const lightGrey = "#EEEEEE";
                                
                                resetDiamondsToBlack(column);
                                
                               
                                coloredDiamonds.forEach(function(diamond, index) {
                                    const rect = diamond.querySelector("rect");
                                    if (rect) {
                                        setTimeout(function() {
                                            rect.setAttribute("fill", color);
                                        }, index * 10); 
                                    }
                                });
                                
                               
                                const delayAfterColored = coloredDiamonds.length * 10;
                                defaultDiamonds.forEach(function(diamond, index) {
                                    const rect = diamond.querySelector("rect");
                                    if (rect) {
                                        setTimeout(function() {
                                            rect.setAttribute("fill", lightGrey);
                                        }, delayAfterColored + (index * 5)); 
                                    }
                                });
                            }
                            
                            
                            function showNextColumn() {
                                const currentColumn = percentageColumns[currentIndex];
                                
                                
                                currentColumn.classList.add("exiting");
                                
                               
                                setTimeout(function() {
                                    
                                    currentColumn.classList.add("d-none");
                                    currentColumn.classList.remove("active", "exiting");
                                    
                                  
                                    currentIndex = (currentIndex + 1) % percentageColumns.length;
                                    
                                    const nextColumn = percentageColumns[currentIndex];
                                    
                                  
                                    const textElement = nextColumn.querySelector(".percentage-text");
                                    
                                    
                                    if (textElement) {
                                        textElement.classList.remove("slide-up-end");
                                        textElement.classList.add("slide-up-start");
                                       
                                        textElement.style.transform = "translateY(120px)";
                                        textElement.style.opacity = "0";
                                    }
                                    
                                   
                                    nextColumn.classList.remove("d-none");
                                    nextColumn.classList.add("active", "entering");
                                    
                               
                                    resetDiamondsToBlack(nextColumn);
                                    
                                    
                                    if (textElement) {
                                        
                                        void textElement.offsetHeight;
                                        
                                       
                                        textElement.style.transform = "";
                                        textElement.style.opacity = "";
                                        
                                       
                                        setTimeout(function() {
                                            textElement.classList.remove("slide-up-start");
                                            textElement.classList.add("slide-up-end");
                                        }, 50);
                                    }
                                    
                                  
                                    setTimeout(function() {
                                        nextColumn.classList.remove("entering");
                                        
                                        
                                        lightUpDiamondsSequentially(nextColumn);
                                    }, 100);
                                }, 300); 
                            }
                            
                            
                            if (percentageColumns.length > 0) {
                                const firstColumn = percentageColumns[0];
                                firstColumn.classList.add("active");
                               
                                const firstText = firstColumn.querySelector(".percentage-text");
                                if (firstText) {
                                    firstText.classList.remove("slide-up-start");
                                    firstText.classList.add("slide-up-end");
                                    
                                    firstText.style.transform = "translateY(0)";
                                    firstText.style.opacity = "1";
                                }
                               
                                const diamondsGrid = firstColumn.querySelector(".diamonds-grid");
                                if (diamondsGrid) {
                                    const color = diamondsGrid.getAttribute("data-percentage-color") || "#010101";
                                    const coloredDiamonds = firstColumn.querySelectorAll(".diamond-percentage[data-is-colored=\"1\"]");
                                    const defaultDiamonds = firstColumn.querySelectorAll(".diamond-percentage[data-is-colored=\"0\"]");
                                    const lightGrey = "#EEEEEE";
                                    
                                    coloredDiamonds.forEach(function(diamond) {
                                        const rect = diamond.querySelector("rect");
                                        if (rect) {
                                            rect.setAttribute("fill", color);
                                        }
                                    });
                                    
                                    defaultDiamonds.forEach(function(diamond) {
                                        const rect = diamond.querySelector("rect");
                                        if (rect) {
                                            rect.setAttribute("fill", lightGrey);
                                        }
                                    });
                                }
                            }
                            
                          
                            setInterval(showNextColumn, 5000);
                        });
                    });
                })();
            </script>';

        }

        return $htmlColumn;

    }


    function ViewAccordion($section_column_id,$language='EN')
    {

        $htmlColumn='';

        $column=SectionColumns::with('accordions')->find($section_column_id);

        if($column){

            $textAlign = $column->alignment_id == 1 ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');

            $htmlColumn.='<div class="row '.$textAlign.'">';

                if($column->width == 1){
                $htmlColumn.='<div class="col-lg-12 col-12">';
                }elseif($column->width == 2){
                $htmlColumn.='<div class="col-lg-9 col-12">';
                }elseif($column->width == 3){
                $htmlColumn.='<div class="col-lg-3"></div><div class="col-lg-6 col-12">';
                }

                foreach($column->accordions as $key=>$accordion){

                    $htmlColumn.= '<div class="mb-4">
                        <div class="accordionTitle medium black ABCDiatypeMedium">'.$accordion->title.'</div>
                        <div class="accordionArrow clickable" status="'.($key == '0' ? '0' : '0').'">
                            <img src="'.asset('frontend/images/'.($key == '0' ? 'arrow-down.png' : 'arrow-down.png')).'" width="30px" />
                        </div>
                        <div class="clear"></div>
                        <div class="accordionText mt-2 small black '.($key == '0' ? 'd-none' : 'd-none').' ">'.$accordion->text.'</div>
                    </div>';
                }

                $htmlColumn.='</div>

            </div>';

        }

        //add accordion script
        $htmlColumn.='<script>
            $(document).ready(function(){
                $(".accordionArrow").click(function(){ 
                    var status=$(this).attr("status");
                    if(status=="0"){
                        $(this).find("img").attr("src","'.asset("frontend/images/arrow-up.png").'");
                        $(this).parent().find(".accordionText").removeClass("d-none");
                        $(this).attr("status","1");
                    }
                    else{
                        $(this).find("img").attr("src","'.asset("frontend/images/arrow-down.png").'");
                        $(this).parent().find(".accordionText").addClass("d-none");
                        $(this).attr("status","0");
                    }
                });
            });
        </script>';

        return $htmlColumn;

    }


    function ViewCountdown($section_column_id,$language='EN')
    {

        $htmlColumn='';

        $column=SectionColumns::with('countdowns')->find($section_column_id);

        if($column){

            $textAlign = $column->alignment_id == 1 ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');

            $htmlColumn.='<div class="row '.$textAlign.'">';

                if($column->width == 1){
                $htmlColumn.='<div class="col-lg-12 col-12">';
                }elseif($column->width == 2){
                $htmlColumn.='<div class="col-lg-9 col-12">';
                }elseif($column->width == 3){
                $htmlColumn.='<div class="col-lg-3"></div><div class="col-lg-6 col-12">';
                }

                foreach($column->countdowns as $countdown){

                    $end = Carbon::parse("{$countdown->end_date} {$countdown->end_time}");
                    $now = now();

                    if ($now->gte($end)) {
                        $days  = 0;
                        $hours = 0;
                    } else {
                        // Full integer days
                        $days = (int) $now->diffInDays($end);

                        // Remaining full hours AFTER days
                        $hours = (int) $now->copy()
                            ->addDays($days)
                            ->diffInHours($end);
                    }

                    $htmlColumn.= '<div class="coutdown">
                    
                        <div class="big black ABCDiatypeMedium text-center">'.$countdown->title.'</div>

                        <div class="row mt-5 align-items-center">
                            <div class="mt-4 col-12 col-lg-4 text-end">
                                <div class="huge black ABCDiatypeMedium">'.$days.'</div>
                                <div class="big black ABCDiatypeMedium">Day(s)</div>
                            </div>
                            <div class="mt-4 col-12 col-lg-4 text-center">
                                <a href="'.($countdown->button_link ?? '#').'">'.getEntryBtnShape($countdown->button_value,$countdown->button_value_arabic,$countdown->shape?->name,$countdown->shapeHover?->name,$countdown->buttonColor->code,$countdown->buttonHoverColor->code,$countdown->buttonBgColor->code,$countdown->buttonHoverBgColor->code).'</a>
                            </div>
                            <div class="mt-4 col-12 col-lg-4 text-start">
                                <div class="huge black ABCDiatypeMedium">'.@$hours.'</div>
                                <div class="big black ABCDiatypeMedium">Hour(s)</div>
                            </div>
                        </div>
                        
                    </div>';

                }

                $htmlColumn.='</div>

            </div>';

        }

        return $htmlColumn;

    }


    function ViewExpandingText($section_column_id,$language='EN')
    {

        $htmlColumn='';

        $column=SectionColumns::with('expandingTexts')->find($section_column_id);

        if($column){

            $textAlign = $column->alignment_id == 1 ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');

            $htmlColumn.='<div class="row '.$textAlign.'" id="expandingTextContainer">';

                if($column->width == 1){
                $htmlColumn.='<div class="col-lg-12 col-12">';
                }elseif($column->width == 2){
                $htmlColumn.='<div class="col-lg-9 col-12">';
                }elseif($column->width == 3){
                $htmlColumn.='<div class="col-lg-3"></div><div class="col-lg-6 col-12">';
                }

                foreach($column->expandingTexts as $expandingText){

                    $htmlColumn.= '<div class="expandingText clickable mb-3 small black ABCDiatypeMedium '.($expandingText->visible == '1' ? '' : 'hiddenText d-none').'">'.$expandingText->text.'</div>';

                }

                $htmlColumn.='</div>

            </div>';

        }

        //add script
        $htmlColumn.='<script>

            $(document).on("click", "#expandingTextContainer", function () {

                const nextHidden = $(this)
                    .find(".expandingText.hiddenText:first");

                if (nextHidden.length) {
                    nextHidden
                        .removeClass("hiddenText d-none")
                        .hide()
                        .slideDown(300);
                }

            });
        </script>';

        return $htmlColumn;

    }


    ##########################################################################################
    ##########################################################################################
    ##########################################################################################
    ##########################################################################################
    ##########################################################################################
    ###############################GENERAL FUNCTIONS##########################################


    function getEntryTitle($entry)
    {
        if($entry->type_id==1){
            return $entry->event_title;
        }
        else if($entry->type_id==2){
            return $entry->program_title;
        }
        else if($entry->type_id==3){
            return $entry->project_title;
        }
        else if($entry->type_id==4){
            return $entry->grantee_name;
        }
        else if($entry->type_id==5){
            return $entry->jury_name;
        }
        else if($entry->type_id==6){
            return $entry->resource_title;
        }
        else if($entry->type_id==7){
            return $entry->news_title;
        }
        else if($entry->type_id==8){
            return $entry->external_title;
        }
    }


    function getEntryLabels($entry)
    {
        $labels=[];
        if($entry->type_id==1){

            $labels[]=$entry->eventCategory?->name;
            $labels[]=date('d M',strtotime($entry->event_start_date));

            // if($entry->event_end_date!=null){
            //     $labels[]=date('d M',strtotime($entry->event_end_date));
            // }

            if($entry->event_start_time!=null){
                $from_to_time=date('h:i',strtotime($entry->event_start_time));
                if($entry->event_end_time!=null){
                    $from_to_time.=" - ".date('h:i A',strtotime($entry->event_end_time));
                }
                $labels[]=$from_to_time;
            }
            
        }
        else if($entry->type_id==2){
            $current = time();

            $start_timestamp = strtotime($entry->program_start_date);
            $end_timestamp   = strtotime($entry->program_end_date);

            if ($end_timestamp < $current) {
                $labels[] = "Closed";
            }
            else {

                $daysLeft = floor(($end_timestamp - $current) / 86400);

                //only show when program already started
                if ($current >= $start_timestamp && $daysLeft > 0) {
                    $labels[] = "Open";
                    $labels[] = "Days left: " . $daysLeft;
                }
                else{
                    $labels[] = "Opens " . date('d M', $start_timestamp);
                    $labels[] = "Closes " . date('d M', $end_timestamp);
                }
            }
        }
        else if($entry->type_id==3){

            // $categories=$entry->projectCategories(json_decode($entry->project_categories_id, true) ?? []);
            // foreach($categories as $category){
            //     $labels[]=$category;
            // }
            
            if($entry->project_program_year_id!=null){
                $labels[]=$entry->projectProgram($entry->project_program_year_id);

                $labels[]=$entry->projectProgramYear($entry->project_program_year_id);
            }

            $countries=$entry->projectCountries(json_decode($entry->project_countries_id, true) ?? []);
            foreach($countries as $country){
                $labels[]=$country;
            }
            
        }
        else if($entry->type_id==4){
            $categories=$entry->granteeCategories(json_decode($entry->grantee_categories_id, true) ?? []);
            foreach($categories as $category){
                $labels[]=$category;
            }
            $labels[]=$entry->granteeCountry?->name;
        }
        else if($entry->type_id==5){
            $labels[]=$entry->juryCountry?->name;
        }
        else if($entry->type_id==6){
            $labels[]=$entry->resourceCategory?->name;
            $labels[]=date('d M Y',strtotime($entry->resource_date));
            $tags=explode(",",$entry->resource_tags);
            foreach($tags as $tag){
                if($tag){$labels[]=$tag;}
            }
        }
        else if($entry->type_id==7){
            $labels[]=date('d M Y',strtotime($entry->news_date));
        }
        else if($entry->type_id==8){
            $labels[]=$entry->externalCategory?->name;
            $labels[]=date('d M Y',strtotime($entry->external_date));
        }

        
        return $labels;
    }


    function setCollectionFilters($collection_id,$collection_type_id,$entries)
    {

        $html='';

        if($collection_type_id==1) //Events
        {
            //Get categories
            $event_categories=[];
            foreach ($entries as $entry) {
                if ($entry->eventCategory) {
                    // Check if this category ID already exists
                    if (!in_array($entry->eventCategory->id, array_column($event_categories, 'id'))) {
                        $event_categories[] = [
                            'id'   => $entry->eventCategory->id,
                            'name' => $entry->eventCategory->name,
                        ];
                    }
                }
            }

            $html.='<div class="filters" style="">
                <div class="filter">
                    <select class="filterDpd filter_event_category">
                        <option value="">Select type</option>';
                        foreach($event_categories as $event_category){
                            $html.='<option value="'.$event_category["id"].'">'.$event_category["name"].'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="filter">
                    <input type="date" name="from_date" class="filter_event_from_date"  placeholder="From Date" />
                </div>
                <div class="filter">
                    <input type="date" name="to_date" class="filter_event_to_date"  placeholder="To Date" />
                </div>
                <div class="filter">
                    <input type="button" class="filterBtn" id="filter-collection-'.$collection_id.'" value="Filter" />
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';

            $html.="<script>
                $(document).ready(function(){
                    
                    $('#filter-collection-".$collection_id."').click(function () {
                        var parent=$(this).parent().parent();
                        var event_category=$(parent).find('.filter_event_category').val();
                        var event_from_date=$(parent).find('.filter_event_from_date').val();
                        var event_to_date=$(parent).find('.filter_event_to_date').val();
                        
                        var filters = {
                            event_category: event_category,
                            event_from_date: event_from_date,
                            event_to_date: event_to_date
                        };

                        getEntries(filters);
                    });

                });
            </script>";
        }
        else if($collection_type_id==2) // Programs
        {
            $html.='<div class="filters" style="">
                <div class="filter">
                    <input type="date" name="start_date" class="filter_program_start_date"  placeholder="Start Date" />
                </div>
                <div class="filter">
                    <input type="date" name="end_date" class="filter_program_end_date"  placeholder="End Date" />
                </div>
                <div class="filter">
                    <input type="button" class="filterBtn" id="filter-collection-'.$collection_id.'" value="Filter" />
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';

            $html.="<script>
                $(document).ready(function(){
                    
                    $('#filter-collection-".$collection_id."').click(function () {
                        var parent=$(this).parent().parent();
                        var program_start_date=$(parent).find('.filter_program_start_date').val();
                        var program_end_date=$(parent).find('.filter_program_end_date').val();
                        
                        var filters = {
                            program_start_date: program_start_date,
                            program_end_date: program_end_date,
                        };

                        getEntries(filters);
                    });

                });
            </script>";

        }
        else if($collection_type_id==3) // Projects
        {
            //Get categories and countries
            $project_categories=[];
            $project_countries=[];
            
            foreach($entries as $entry){

                $categories=$entry->projectCategories(json_decode($entry->project_categories_id, true) ?? []);
                foreach($categories as $category){
                    if(!in_array($category,$project_categories)){
                        $project_categories[]=$category;
                    }
                }

                $countries=$entry->projectCountries(json_decode($entry->project_countries_id, true) ?? []);
                foreach($countries as $country){
                    if(!in_array($country,$project_countries)){
                        $project_countries[]=$country;
                    }
                }
                
            }

            $html.='<div class="filters" style="">
                <div class="filter">
                    <select class="filterDpd filter_project_category">
                        <option value="">Select theme</option>';
                        foreach($project_categories as $category){
                            $html.='<option '.$category.'>'.$category.'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="filter">
                    <select class="filterDpd filter_project_country">    
                        <option value="">Select country</option>';
                        foreach($project_countries as $country){
                            $html.='<option '.$country.'>'.$country.'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';

            $html.="<script>
                $(document).ready(function(){

                    $('.filter_project_category, .filter_project_country').change(function () {

                        var allCards=0;
                        var hiddenCards=0;

                        var project_category_name = $.trim($('.filter_project_category').val());
                        var project_country_name = $.trim($('.filter_project_country').val());
                        
                        $(this).parent().parent().parent().find('.entry_card').each(function () {

                            var entry_categories_name = $.trim($(this).attr('project_categories'));
                            var entry_countries_name = $.trim($(this).attr('project_countries'));

                            // Category match
                            var match_category = (
                                entry_categories_name.includes(project_category_name) ||
                                project_category_name === ''
                            );
                            
                            // Country match
                            var match_country = (
                                entry_countries_name.includes(project_country_name) ||
                                project_country_name === ''
                            );
                            

                            if (match_category && match_country) {
                                $(this).parent().removeClass('d-none');
                            } else {
                                $(this).parent().addClass('d-none');
                                hiddenCards++;
                            }

                            allCards++;
                        });

                        if(allCards==hiddenCards){
                            $(this).parent().parent().parent().find('.filterEmptyResult').removeClass('d-none');
                        }
                        else{
                            $(this).parent().parent().parent().find('.filterEmptyResult').addClass('d-none');
                        }

                    });

                });
            </script>";
        }
        else if($collection_type_id==4) // Grantees
        {
            //Get categories and countries
            $grantee_categories=[];
            $grantee_countries=[];
            foreach($entries as $entry){

                $countryId = $entry->granteeCountry?->id;
                if ($countryId && !in_array($countryId, array_column($grantee_countries, 'id'))) {
                    $grantee_countries[] = [
                        'id'   => $countryId,
                        'name' => $entry->granteeCountry?->name,
                    ];
                }

                $categoriesId=json_decode($entry->grantee_categories_id, true) ?? [];

                foreach($categoriesId as $categoryId){
                    if ($categoryId && !in_array($categoryId, array_column($grantee_categories, 'id'))) {
                        $grantee_categories[]=[
                            'id'   => $categoryId,
                            'name' => GranteeCategories::find($categoryId)?->name,
                        ];
                    }
                }

            }


            $html.='<div class="filters" style="">
                <div class="filter">
                    <select class="filterDpd filter_grantee_country">    
                        <option value="">Select country</option>';
                        foreach($grantee_countries as $country){
                            $html.='<option value="'.$country["id"].'">'.$country["name"].'</option>';
                        }
                    $html.='</select>
                </div>    
                <div class="filter">
                    <select class="filterDpd filter_grantee_category">
                        <option value="">Select theme</option>';
                        foreach($grantee_categories as $category){
                            $html.='<option value="'.$category["id"].'">'.$category["name"].'</option>';
                        }
                    $html.='</select>
                </div>
                
                <div class="filter">
                    <input type="button" class="filterBtn" id="filter-collection-'.$collection_id.'" value="Filter" />
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';

            $html.="<script>
                $(document).ready(function(){
                    
                    $('#filter-collection-".$collection_id."').click(function () {
                        var parent=$(this).parent().parent();
                        var grantee_country=$(parent).find('.filter_grantee_country').val();
                        var grantee_category=$(parent).find('.filter_grantee_category').val();
                        
                        var filters = {
                            grantee_country: grantee_country,
                            grantee_category: grantee_category,
                        };

                        getEntries(filters);
                    });

                });
            </script>";
        }
        else if($collection_type_id==5) // Jurors
        {
            //Get Countries
            $juror_countries=[];
            $juror_ids=[];
            foreach($entries as $entry){

                $countryId = $entry->juryCountry?->id;
                if ($countryId && !in_array($countryId, array_column($juror_countries, 'id'))) {
                    $juror_countries[] = [
                        'id'   => $countryId,
                        'name' => $entry->juryCountry?->name,
                    ];
                }

                //get all jurors ids
                if(!in_array($entry->id,$juror_ids)){
                    $juror_ids[]=$entry->id;
                }
            }
            
            //Get Programs & Years
            $juror_programs=[];
            $juror_program_years=[];

            $jurorsProgramsYears=ProgramYearJurors::WHEREIN('juror_id',$juror_ids)->get();

            foreach($jurorsProgramsYears as $jurorProgramYear){
                //Set Programs
                $programId = $jurorProgramYear->programYear?->program?->id;
                if ($programId && !in_array($programId, array_column($juror_programs, 'id'))) {
                    $juror_programs[] = [
                        'id'   => $programId,
                        'name' => $jurorProgramYear->programYear?->program?->program_title,
                    ];
                }
                
                //Set Years
                $programYearId = $jurorProgramYear->programYear?->id;
                $programYear = $jurorProgramYear->programYear?->year;
                
                if ($programYear && !in_array($programYear, array_column($juror_program_years, 'name'))) {
                    $juror_program_years[] = [
                        //'id'   => $programYearId,
                        'id'   => $jurorProgramYear->programYear?->year,
                        'name' => $jurorProgramYear->programYear?->year,
                    ];
                }
            }

            $html.='<div class="filters" style="">
                <div class="filter">
                    <select class="filterDpd filter_juror_country">    
                        <option value="">Select country</option>';
                        foreach($juror_countries as $country){
                            $html.='<option value="'.$country["id"].'">'.$country["name"].'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="filter">
                    <select class="filterDpd filter_juror_program_year">    
                        <option value="">Select year</option>';
                        foreach($juror_program_years as $juror_program_year){
                            $html.='<option value="'.$juror_program_year["id"].'">'.$juror_program_year["name"].'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="filter">
                    <select class="filterDpd filter_juror_program">    
                        <option value="">Select program</option>';
                        foreach($juror_programs as $juror_program){
                            $html.='<option value="'.$juror_program["id"].'">'.$juror_program["name"].'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="filter">
                    <input type="button" class="filterBtn" id="filter-collection-'.$collection_id.'" value="Filter" />
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';

            $html.="<script>
                $(document).ready(function(){
                    
                    $('#filter-collection-".$collection_id."').click(function () {
                        var parent=$(this).parent().parent();
                        var juror_country=$(parent).find('.filter_juror_country').val();
                        var juror_program_year=$(parent).find('.filter_juror_program_year').val();
                        var juror_program=$(parent).find('.filter_juror_program').val();
                        
                        var filters = {
                            juror_country: juror_country,
                            juror_program_year: juror_program_year,
                            juror_program: juror_program,
                        };

                        getEntries(filters);
                    });

                });
            </script>";
        }
        else if($collection_type_id==6) //Resources
        {

            //Get categories 
            $resource_categories=[];
            foreach ($entries as $entry) {
                if ($entry->resourceCategory) {
                    // Check if this category ID already exists
                    if (!in_array($entry->resourceCategory->id, array_column($resource_categories, 'id'))) {
                        $resource_categories[] = [
                            'id'   => $entry->resourceCategory->id,
                            'name' => $entry->resourceCategory->name,
                        ];
                    }
                }
            }

            $html.='<div class="filters" style="">
                <div class="filter">
                    <select class="filterDpd filter_resource_category">
                        <option value="">Select category</option>';
                        foreach($resource_categories as $category){
                            $html.='<option value="'.$category["id"].'">'.$category["name"].'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="filter">
                    <input type="date" name="from_date" class="filter_resource_from_date"  placeholder="From Date" />
                </div>
                <div class="filter">
                    <input type="date" name="to_date" class="filter_resource_to_date"  placeholder="To Date" />
                </div>
                <div class="filter">
                    <input type="button" class="filterBtn" id="filter-collection-'.$collection_id.'" value="Filter" />
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';
            
            $html.="<script>
                $(document).ready(function(){
                    
                    $('#filter-collection-".$collection_id."').click(function () {
                        var parent=$(this).parent().parent();
                        var resource_category=$(parent).find('.filter_resource_category').val();
                        var resource_from_date=$(parent).find('.filter_resource_from_date').val();
                        var resource_to_date=$(parent).find('.filter_resource_to_date').val();
                        var filters = {
                            resource_category: resource_category,
                            resource_from_date: resource_from_date,
                            resource_to_date: resource_to_date,
                        };

                        getEntries(filters);
                    });

                });
            </script>";
            
        }
        else if($collection_type_id==7) //News
        {

            $html.='<div class="filters" style="">
                <div class="filter">
                    <input type="text" name="tags" class="filter_news_tags"  placeholder="Tags" />
                </div>
                <div class="filter">
                    <input type="date" name="from_date" class="filter_news_from_date"  placeholder="From Date" />
                </div>
                <div class="filter">
                    <input type="date" name="to_date" class="filter_news_to_date"  placeholder="To Date" />
                </div>
                <div class="filter">
                    <input type="button" class="filterBtn" id="filter-collection-'.$collection_id.'" value="Filter" />
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';

            $html.="<script>
                $(document).ready(function(){
                    
                    $('#filter-collection-".$collection_id."').click(function () {
                        var parent=$(this).parent().parent();
                        var news_tags=$(parent).find('.filter_news_tags').val();
                        var news_from_date=$(parent).find('.filter_news_from_date').val();
                        var news_to_date=$(parent).find('.filter_news_to_date').val();
                        
                        var filters = {
                            news_tags: news_tags,
                            news_from_date: news_from_date,
                            news_to_date: news_to_date,
                        };

                        getEntries(filters);
                    });

                });
            </script>";
        }
        else if($collection_type_id==8) //Externals
        {

            //Get categories 
            $external_categories=[];
            foreach ($entries as $entry) {
                if ($entry->externalCategory) {
                    // Check if this category ID already exists
                    if (!in_array($entry->externalCategory->id, array_column($external_categories, 'id'))) {
                        $external_categories[] = [
                            'id'   => $entry->externalCategory->id,
                            'name' => $entry->externalCategory->name,
                        ];
                    }
                }
            }

            $html.='<div class="filters" style="">
                <div class="filter">
                    <select class="filterDpd filter_external_category">
                        <option value="">Select category</option>';
                        foreach($external_categories as $category){
                            $html.='<option value="'.$category["id"].'">'.$category["name"].'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="filter">
                    <input type="date" name="from_date" class="filter_external_from_date"  placeholder="From Date" />
                </div>
                <div class="filter">
                    <input type="date" name="to_date" class="filter_external_to_date"  placeholder="To Date" />
                </div>
                <div class="filter">
                    <input type="button" class="filterBtn" id="filter-collection-'.$collection_id.'" value="Filter" />
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';
            
            $html.="<script>
                $(document).ready(function(){
                    
                    $('#filter-collection-".$collection_id."').click(function () {
                        var parent=$(this).parent().parent();
                        var external_category=$(parent).find('.filter_external_category').val();
                        var external_from_date=$(parent).find('.filter_external_from_date').val();
                        var external_to_date=$(parent).find('.filter_external_to_date').val();
                        var filters = {
                            external_category: external_category,
                            external_from_date: external_from_date,
                            external_to_date: external_to_date,
                            
                        };

                        getEntries(filters);
                    });

                });
            </script>";
            
        }

        return $html;
    }   


    function getEntryDetails($collection_type_id,$entry)
    {

        $entryDetails=[];

        if($collection_type_id==1){
            $entry_title=$entry->event_title;
            $entry_text=$entry->event_text;
            $entry_href=route('entry.view', ['entryType'=>'event','id'=>$entry->id]);
            $entry_target='';
        }
        else if($collection_type_id==2){
            $entry_title=$entry->program_title;
            $entry_text=$entry->program_text;
            $entry_href=route('entry.view', ['entryType'=>'program','id'=>$entry->id]);
            $entry_target='';
        }
        else if($collection_type_id==3){
            $entry_title=$entry->project_title;
            $entry_text=$entry->project_text;
            $entry_href=route('entry.view', ['entryType'=>'project','id'=>$entry->id]);
            $entry_target='';
        }
        else if($collection_type_id==4){
            $entry_title=$entry->grantee_name;
            $entry_text=$entry->grantee_text;
            $entry_href=route('entry.view', ['entryType'=>'grantee','id'=>$entry->id]);
            $entry_target='';
        }
        else if($collection_type_id==5){
            $entry_title=$entry->jury_name;
            $entry_text=$entry->jury_text;
            $entry_href=route('entry.view', ['entryType'=>'juror','id'=>$entry->id]);
            $entry_target='';
        }
        else if($collection_type_id==6){
            $entry_title=$entry->resource_title;
            $entry_text=$entry->resource_text;
            $entry_href=route('entry.view', ['entryType'=>'resource','id'=>$entry->id]);
            $entry_target='';
        }
        else if($collection_type_id==7){
            $entry_title=$entry->news_title;
            $entry_text=$entry->news_text;
            $entry_href=route('entry.view', ['entryType'=>'news','id'=>$entry->id]);
            $entry_target='';
        }
        else if($collection_type_id==8){
            $entry_title=$entry->external_title;
            $entry_text=$entry->external_text;
            $entry_href=$entry->external_link;
            $entry_target='_blank';
        }
        else if($collection_type_id==9){
            $entry_title=$entry->team_name;
            $entry_text=$entry->team_text;
            $entry_href='';
            $entry_target='';
        }
        else if($collection_type_id==10){
            $entry_title=$entry->board_title;
            $entry_text=$entry->board_text;
            $entry_href='';
            $entry_target='';
        }

        $entryDetails=['entry_title'=>$entry_title,'entry_text'=>$entry_text,'entry_href'=>$entry_href,'entry_target'=>$entry_target];

        return $entryDetails;
    }


    function getEntryBtnShape($value,$value_arabic,$shape,$shape_hover,$text_color,$hover_text_color,$bg_color,$hover_bg_color)
    {

        if($shape=="Circle" && $shape_hover=="Diamond")
        {
            $button = view('frontend.btn-animation.circle-diamond', [
                'value'=>$value,
                'value_arabic'=>$value_arabic,
                'text_color' => $text_color,
                'hover_text_color' => $hover_text_color,
                'bg_color' => $bg_color,
                'hover_bg_color' => $hover_bg_color,
            ])->render();
        }
        else if($shape=="Circle" && $shape_hover=="Square")
        {
            $button = view('frontend.btn-animation.circle-square', [
                'value'=>$value,
                'value_arabic'=>$value_arabic,
                'text_color' => $text_color,
                'hover_text_color' => $hover_text_color,
                'bg_color' => $bg_color,
                'hover_bg_color' => $hover_bg_color,
            ])->render();
        }
        else if($shape=="Square" && $shape_hover=="Circle")
        {
            $button = view('frontend.btn-animation.square-circle', [
                'value'=>$value,
                'value_arabic'=>$value_arabic,
                'text_color' => $text_color,
                'hover_text_color' => $hover_text_color,
                'bg_color' => $bg_color,
                'hover_bg_color' => $hover_bg_color,
            ])->render();
        }
        else if($shape=="Square" && $shape_hover=="Diamond")
        {
            $button = view('frontend.btn-animation.square-diamond', [
                'value'=>$value,
                'value_arabic'=>$value_arabic,
                'text_color' => $text_color,
                'hover_text_color' => $hover_text_color,
                'bg_color' => $bg_color,
                'hover_bg_color' => $hover_bg_color,
            ])->render();
        }
        else if($shape=="Diamond" && $shape_hover=="Circle")
        {
            $button = view('frontend.btn-animation.diamond-circle', [
                'value'=>$value,
                'value_arabic'=>$value_arabic,
                'text_color' => $text_color,
                'hover_text_color' => $hover_text_color,
                'bg_color' => $bg_color,
                'hover_bg_color' => $hover_bg_color,
            ])->render();
        }
        else if($shape=="Diamond" && $shape_hover=="Square")
        {
            $button = view('frontend.btn-animation.diamond-square', [
                'value'=>$value,
                'value_arabic'=>$value_arabic,
                'text_color' => $text_color,
                'hover_text_color' => $hover_text_color,
                'bg_color' => $bg_color,
                'hover_bg_color' => $hover_bg_color,
            ])->render();
        }

        return @$button;
    }


    function getLogoActiveElements()
    {

        $logoElements=Logo::ORDERBY('id','ASC')->get();

        return $logoElements;
    }
    

    
?>