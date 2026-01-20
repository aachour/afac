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
    use App\Models\ProjectGrantees;
    use App\Models\Logo;
    use Carbon\Carbon;
            
    function ViewEntryData($entry_id,$language='EN')
    {

        $entry=Entries::find($entry_id);

        if($entry){
            
            //Get entry labels
            $labels=getEntryLabels($entry);

            $html='<div class="fullContainer">
                <div class="centerContainer" style="background:'.$entry->ImageBgColor?->code.';">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-12 text-center">
                            <div class="labels">';
                               $html.='<div class="label micro black ABCDiatypeMedium rounded">'.$entry->type->name.'</div>';
                                foreach($labels as $label){
                                    $html.='<div class="label micro">'.$label.'</div>';
                                }
                            $html.='</div>
                            <div class="mt-3 huge black ABCDiatypeMedium">'.getEntryTitle($entry).'</div>
                        </div>
                        <div class="col-lg-6 col-12">';
                            if($entry->image_featured){
                                $html.='<img src="'.asset('storage/'.$entry->image_featured).'" width="100%" />';
                            }else{
                                $html.='<img src="'.asset('frontend/images/default-image.jpg').'" width="100%" />';
                            }
                        $html.='</div>
                    </div>
                </div>
            </div>';

            //show at a glance for Supported Project & Grantee. 
            if($entry->type_id==3 || $entry->type_id==4){
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

        $collection_type_id=$collection->type_id;
        $calendar_view=$collection->calendar_view;
        $show_name=$collection->show_name;
        $show_description=$collection->show_description;
        $show_view_all=$collection->show_view_all;
        $view_all_title=$collection->view_all_title;
        $view_all_link=$collection->view_all_link;
        $button_text=$collection->button_text;
        $with_border_bottom=$collection->with_border_bottom;
        $entries_selection=$collection->entries_selection;
        $entries_per_row=$collection->entries_per_row;
        $entries_layout=$collection->entries_layout;
        $with_filters=$collection->with_filters;
        $with_label=$collection->with_label;
        $with_featured=$collection->with_featured_image;
        $all_featured=$collection->all_featured;
        
        $featured_image_width=$collection->featured_image_width;

        $featured_width=0;
        $featured_margin=0;
        if($featured_image_width==1) //full
        {
            $featured_width='100%';
            $featured_margin='0%';
        }
        else if($featured_image_width==2) //three quarter
        {
            $featured_width='74.3%';
            $featured_margin='25.3%';
        }

        $featured_image_bgColor = $collection->featuredImageBgColor?->code ?? '#ffffff';
        
        $title_position='top:15px;';
        $labels_position='bottom:15px;';

        if($collection->title_position=='1')
        {
            $title_position='bottom:15px;';
            $labels_position='top:15px;';
        }

        //Get All Entries
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
            //     $query->where('event_date', '>=', date('Y-m-d'));
            // }

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

        $html="";

        //Set Filters
        if($with_filters==1){   
            $html.=setCollectionFilters($collection_type_id,$entries);
        }

        $bgColor = $collection->bgColor?->code ?? '#ffffff';
        
        $sliderCollection = $entries_layout == 2 ? 'sliderCollection' : '';
        
        //Show Calendar View
        if($collection_type_id==1 && $calendar_view==1)
        {

            $events=[];

            foreach($entries as $entry){
                $obj=[
                    'id'=>$entry->id,
                    'event_date'=>$entry->event_date,
                ];
                $events [] = $obj;
            }  

            $datesEvents = [];
            $monthCounters = [];

            foreach ($events as $event) {
                $monthKey = date('Y-m', strtotime($event['event_date']));

                if (!isset($monthCounters[$monthKey])) {
                    $monthCounters[$monthKey] = 0;
                }

                if ($monthCounters[$monthKey] < 3) {
                    $datesEvents[$monthKey][] = $event;
                    $monthCounters[$monthKey]++;
                }
            }

            $html.='<div class="collection '.$sliderCollection.'" style="background-color:'.$bgColor.';">';
                
                foreach($datesEvents as $date=>$dateEvents){

                    $html.='<div class="entries">
                            
                        <div class="entry">
                            <div class="big black ABCDiatypeMedium">'.date('M Y',strtotime($date)).'</div>
                        </div>';

                        foreach($dateEvents as $event){

                            $image_path = asset('frontend/images/default-image.jpg');
                            if (!empty($entry->image)) {
                                $image_path = asset('storage/' . $entry->image);
                            }

                            //get entry details
                            $entryDetails=getEntryDetails($collection_type_id,$entry);
                            $entry_title=$entryDetails["entry_title"];
                            $entry_text=$entryDetails["entry_text"];
                            $entry_href=$entryDetails["entry_href"];
                            $entry_target=$entryDetails["entry_target"];

                            $html.='<div class="swiper-slide entry">';

                                $labels=getEntryLabels($entry);

                                $html .= view('frontend.entry-hover-animation', [
                                    'collection_type_id'=>$collection_type_id,
                                    'entry_href'=>$entry_href,
                                    'entry_target'=>$entry_target,
                                    'image_path'=>$image_path,
                                    'entry_title' => $entry_title,
                                    'entry_text' => $entry_text,
                                    'title_position'=>$title_position,
                                    'with_label' => $with_label,
                                    'labels_position'=>$labels_position,
                                    'entry_type_name' => $entry->type->name,
                                    'collection_type_id' => $collection_type_id,
                                    'labels' => $labels,
                                    'button_text'=>$button_text,
                                    'featured'=>'0',
                                ])->render();
                                                                    
                            $html .='</div>';

                        }
                            
                        $html.='<div class="clear"></div>';

                    $html.='</div>';

                }

            $html.='</div>';
            
        }
        else
        {

            $html.='<div class="collection '.$sliderCollection.'" style="background-color:'.$bgColor.';">';

                if( ($show_name==1 || $show_description==1) && $featured_width!='74.3%' ){
                    $html.='<div class="titleDescription">';
                        if($show_name==1){
                            $html.='<div class="black big ABCDiatypeMedium">'.$collection->name.'</div>';
                        }
                        if($show_description==1){
                            $html.='<div class="topSpacerSmall black tiny ABCDiatypeMedium">'.$collection->description.'</div>';
                        }
                    $html.='</div>';
                }

                if( ($with_featured==0 || $show_view_all==1) && $featured_width!='74.3%'){
                    $html.='<div class="viewAll">
                        <a href="'.$view_all_link.'" class="black tiny ABCDiatypeBlack">'.$view_all_title.' &nbsp;<img src="'.asset('frontend/images/view-all-btn-en.png').'" width="9px" style="margin-top:5px;"></a>
                    </div>';
                }

                $html.='<div class="clear"></div>';


                if(count($entries)>0)
                {

                    //show featured entry on top
                    if($with_featured==1) 
                    { 

                        foreach($entries as $key=>$entry){
                            
                            $image_path = asset('frontend/images/default-image.jpg');
                            if (!empty($entry->image)) {
                                $image_path = asset('storage/' . $entry->image_featured);
                            }

                            //get entry details
                            $entryDetails=getEntryDetails($collection_type_id,$entry);
                            $entry_title=$entryDetails["entry_title"];
                            $entry_text=$entryDetails["entry_text"];
                            $entry_href=$entryDetails["entry_href"];
                            $entry_target=$entryDetails["entry_target"];

                            //desktop view
                            $html.='<a href="'.$entry_href.'" target="'.$entry_target.'">
                                <div class="desktopOnly">';
                                    if( ($show_name==1 || $show_view_all==1) && $featured_width=='74.3%' && $key==0){
                                        $html.='<div class="featured_title_view_all">';
                                            if($show_name==1){
                                                $html.='<div class="black big ABCDiatypeMedium">'.$collection->name.'</div>';
                                            }
                                            if($show_view_all==1){
                                                $html.='<div class="topSpacerSmaller">
                                                    <a href="'.$view_all_link.'" class="black tiny ABCDiatypeBlack">'.$view_all_title.' &nbsp;<img src="'.asset('frontend/images/view-all-btn-en.png').'" width="9px" style="margin-top:5px;"></a>
                                                </div>';
                                            }
                                        $html.='</div>';
                                    }
                                    $html.='<div class="topSpacer featured_entry" style="background:'.$featured_image_bgColor.'; width:'.$featured_width.'; margin-left:'.$featured_margin.';">';
                                        $html.='<div class="featured_info">
                                            <div class="title_or_labels" style="'.$title_position.'">
                                                <div class="medium white ABCDiatypeMedium">'.$entry_title.'</div>
                                                <div class="topSpacerSmall tiny white threeQuartersText">'.$entry_text.'</div>';
                                            $html.='</div>';
                                            if($with_label==1)
                                            {
                                                $labels=getEntryLabels($entry);
                                                $html.='<div class="title_or_labels threeQuartersText" style="'.$labels_position.'">
                                                    <div class="label micro ABCDiatypeMedium">'.$entry->type->name.'</div>
                                                    <div class="label micro rounded ABCDiatypeMedium">'.@$labels[0].'</div>
                                                    <div class="label micro rounded ABCDiatypeMedium">'.@$labels[1].' - '.@$labels[2].'</div>
                                                    <div class="clear">&nbsp;</div>
                                                </div>';
                                            }
                                        $html.='</div>
                                        <div class="featured_image">';
                                            $html .= view('frontend.entry-hover-animation', [
                                                'collection_type_id'=>$collection_type_id,
                                                'entry_text'=>$entry_text,
                                                'image_path'=>$image_path,
                                                'entry_href'=>$entry_href,
                                                'entry_target'=>$entry_target,
                                                'button_text'=>$button_text,
                                                'featured'=>'1',
                                                ])->render();
                                        $html.='</div>
                                    </div>
                                </div>
                            </a>';
                            
                            //mobile view
                            $html.='<a href="'.$entry_href.'" target="'.$entry_target.'">
                                <div class="entries mobileOnly">';
                                    if( ($show_name==1 || $show_view_all==1) && $featured_width=='74.3%' && $key==0){
                                        if($show_name==1){
                                            $html.='<div class="black big ABCDiatypeMedium">'.$collection->name.'</div>';
                                        }
                                        if($show_view_all==1){
                                            $html.='<div class="topSpacerSmaller">
                                                <a href="'.$view_all_link.'" class="black tiny ABCDiatypeBlack">'.$view_all_title.' &nbsp;<img src="'.asset('frontend/images/view-all-btn-en.png').'" width="9px" style="margin-top:5px;"></a>
                                            </div>';
                                        }
                                    }
                                    $html.='<div class="featured_entry_mobile" style="background:'.$featured_image_bgColor.';">
                                        <img src="'.$image_path.'" width="100%" />
                                        <div class="description">
                                            <div class="title_or_labels medium white ABCDiatypeMedium" style="'.$title_position.'">'.$entry_title.'</div>';
                                            if($with_label==1)
                                            {
                                                $html.='<div class="title_or_labels" style="'.$labels_position.'">
                                                    <div class="label micro black ABCDiatypeMedium">'.$entries[0]->type->name.'</div>';
                                                    $labels=getEntryLabels($entry);
                                                    $html.='<div class="title_or_labels threeQuartersText" style="'.$labels_position.'">
                                                        <div class="label micro ABCDiatypeMedium">'.$entry->type->name.'</div>
                                                        <div class="label micro rounded ABCDiatypeMedium">'.@$labels[0].'</div>
                                                        <div class="label micro rounded ABCDiatypeMedium">'.@$labels[1].' - '.@$labels[2].'</div>
                                                        <div class="clear">&nbsp;</div>
                                                    </div>
                                                </div>';
                                            }
                                        $html.='</div>
                                    </div>
                                </div>
                            </a>';

                            if($all_featured==0)
                            {
                                break; 
                            }  
                        }
                                            
                    }

                    if($all_featured==0 || $all_featured==null)
                    { 

                        $html.='<div class="entries">';
                            
                            $entries_count=0;

                            if($entries_layout==1 && $entries_per_row<4){
                                $html.='
                                <style>
                                    @media(min-width:900px){
                                        .collection .entries .entry:nth-child(4n){
                                            margin-right:2% !important;
                                        }
                                    }
                                </style>';
                            }

                            //Open slider
                            if($entries_layout==2) 
                            {

                                $html.='<style>
                                    .sliderCollection .entries .entry:nth-child(4n){
                                        margin-right:1.2% !important;
                                    }
                                </style>';

                                $html.='<div class="swiper" id="swiper'.$collection_id.'" style="width:102.5%; padding-bottom:15px;">
                                    <div class="swiper-wrapper">';
                            }

                            //Fetch all entries
                            foreach($entries as $key=>$entry)
                            {

                                if ($with_featured==1 && $key ==0) {
                                    continue; // skip first
                                }

                                $image_path = asset('frontend/images/default-image.jpg');
                                if (!empty($entry->image)) {
                                    $image_path = asset('storage/' . $entry->image);
                                }

                                //get entry details
                                $entryDetails=getEntryDetails($collection_type_id,$entry);
                                $entry_title=$entryDetails["entry_title"];
                                $entry_text=$entryDetails["entry_text"];
                                $entry_href=$entryDetails["entry_href"];
                                $entry_target=$entryDetails["entry_target"];

                                $html.='<div class="swiper-slide entry">';

                                    $labels=getEntryLabels($entry);

                                    $html .= view('frontend.entry-hover-animation', [
                                        'collection_type_id'=>$collection_type_id,
                                        'entry_href'=>$entry_href,
                                        'entry_target'=>$entry_target,
                                        'image_path'=>$image_path,
                                        'entry_title' => $entry_title,
                                        'entry_text' => $entry_text,
                                        'title_position'=>$title_position,
                                        'with_label' => $with_label,
                                        'labels_position'=>$labels_position,
                                        'entry_type_name' => $entry->type->name,
                                        'collection_type_id' => $collection_type_id,
                                        'labels' => $labels,
                                        'button_text'=>$button_text,
                                        'featured'=>'0',
                                        'event_category_name'=>$entry->eventCategory?->name,
                                        'event_date'=>$entry->event_date,
                                        'program_start_date'=>$entry->program_start_date,
                                        'program_end_date'=>$entry->program_end_date,
                                        'project_categories'=>$entry->projectCategoriesName(json_decode($entry->project_categories_id ?? '[]', true) ?? []),
                                        'project_countries'=>$entry->projectCountries(json_decode($entry->project_countries_id ?? '[]', true) ?? []),
                                        'grantee_categories'=>$entry->granteeCategories(json_decode($entry->grantee_categories_id ?? '[]', true) ?? []),
                                        'grantee_country'=>$entry->granteeCountry?->name,
                                        'jury_country_id'=>$entry->jury_country_id,
                                        'resource_date'=>$entry->resource_date,
                                        'news_date'=>$entry->news_date,
                                    ])->render();
                                                                        
                                $html .='</div>';

                                //check entries per row
                                $entries_count++;

                                if($entries_layout==1 && $entries_count % $entries_per_row==0){
                                    $html.='<div class="clear">&nbsp;</div>';
                                }

                            }

                            $html.='<div class="clear"></div>';
                            
                            //Close Slider
                            if($entries_layout==2) 
                            {
                                    $html.='</div>                             
                                </div>

                                <!-- Navigation buttons --> 
                                <div class="mt-4">
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>';
                            }

                        $html.='</div>';
                    }

                }

            $html.='</div>';

            //add swiper JS 
            $html.='<script> 
                if($("#swiper'.$collection_id.'").length>0){
                    const swiper'.$collection_id.' = new Swiper("#swiper'.$collection_id.'", {
                        //loop: true,
                        grid: {
                            rows: 1           
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        /*autoplay: {
                            delay: 2500,
                            disableOnInteraction: false,
                        },*/
                        effect: "slide",
                        speed: 800,
                        breakpoints: {
                            // when window width is >= 320px
                            576: {
                                slidesPerView: 0.85,
                                spaceBetween: 0
                            },
                            // when window width is >= 992px
                            900: {
                                slidesPerView: 4.12,
                                spaceBetween: 20
                            },
                        }
                    });
                }
            </script>';
        }
    
        //Check shadow bottom
        if($with_border_bottom == 1){
            $html.='<div class="collectionWithBorder"></div>';
        }

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
                        
                            <a href="' . ($generalInput->button_link ?? '#') . '">'.getEntryBtnShape($generalInput->button_value,$generalInput->button_value_arabic,$generalInput->shape->name,$generalInput->shapeHover->name,$generalInput->buttonColor->code,$generalInput->buttonHoverColor->code,$generalInput->buttonBgColor->code,$generalInput->buttonHoverBgColor->code).'</a>
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
                                <a href="'.($countdown->button_link ?? '#').'">'.getEntryBtnShape($countdown->button_value,$countdown->button_value_arabic,$countdown->shape->name,$countdown->shapeHover->name,$countdown->buttonColor->code,$countdown->buttonHoverColor->code,$countdown->buttonBgColor->code,$countdown->buttonHoverBgColor->code).'</a>
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

            $htmlColumn.='<div class="row '.$textAlign.'">';

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

            $(document).on("click", ".expandingText", function () {

                // find the first hidden expandingText AFTER the clicked one
                const nextHidden = $(this)
                    .closest(".expandingText")
                    .nextAll(".expandingText.hiddenText:first");

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
            $labels[]=date('d M',strtotime($entry->event_date));
            $labels[]=date('h:i',strtotime($entry->event_start_time));
            $labels[]=date('h:i',strtotime($entry->event_to_time));
        }
        else if($entry->type_id==2){
            $labels[]=date('d M',strtotime($entry->program_start_date));
            $labels[]=date('d M',strtotime($entry->program_end_date));
        }
        else if($entry->type_id==3){

            $categories=$entry->projectCategories(json_decode($entry->project_categories_id, true) ?? []);
            foreach($categories as $category){
                $labels[]=$category;
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
            $labels[]=date('d M',strtotime($entry->resource_date));
        }
        else if($entry->type_id==7){
            $labels[]=date('d M',strtotime($entry->news_date));
        }
        else if($entry->type_id==8){
            $labels[]=$entry->externalCategory?->name;
        }

        
        return $labels;
    }


    function setCollectionFilters($collection_type_id,$entries)
    {

        $html='';

        if($collection_type_id==1) //Events
        {
            //Get categories
            $event_categories=[];
            foreach($entries as $entry){
                if(!in_array($entry->eventCategory?->name,$event_categories)){
                    $event_categories[] = $entry->eventCategory->name;
                }
            }

            $html.='<div class="filters" style="">
                <div class="filter">
                    <select class="filterDpd filter_event_category">
                        <option value="">Select type</option>';
                        foreach($event_categories as $event_category){
                            $html.='<option '.$event_category.'>'.$event_category.'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="filter">
                    <input type="date" name="from_date" class="filter_event_from_date"  placeholder="From Date" />
                </div>
                <div class="filter">
                    <input type="date" name="to_date" class="filter_event_to_date"  placeholder="To Date" />
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';

            $html.="<script>
                $(document).ready(function(){

                    $('.filter_event_category, .filter_event_from_date, .filter_event_to_date').change(function () {

                        var event_category_name = $.trim($('.filter_event_category').val());
                        var event_from_date = new Date($('.filter_event_from_date').val());
                        var event_to_date = new Date($('.filter_event_to_date').val());

                        // Normalize time
                        event_from_date.setHours(0, 0, 0, 0);
                        event_to_date.setHours(0, 0, 0, 0);

                        $(this).parent().parent().parent().find('.entry_card').each(function () {

                            var entry_category_name = $.trim($(this).attr('event_category_name'));
                            var entry_date = new Date($.trim($(this).attr('event_date')));
                            entry_date.setHours(0, 0, 0, 0);

                            // Category match
                            var match_category = (entry_category_name === event_category_name || event_category_name === '');

                            // Date match
                            var is_from_date_set = !isNaN(event_from_date.getTime());
                            var is_to_date_set = !isNaN(event_to_date.getTime());

                            var match_date = true;

                            if (is_from_date_set && is_to_date_set) {
                                match_date = (entry_date >= event_from_date && entry_date <= event_to_date);
                            } else if (is_from_date_set) {
                                match_date = entry_date.getTime() === event_from_date.getTime();
                            } else if (is_to_date_set) {
                                match_date = entry_date.getTime() === event_to_date.getTime();
                            }

                            if (match_category && match_date) {
                                $(this).parent().removeClass('d-none');
                            } else {
                                $(this).parent().addClass('d-none');
                            }
                        });
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
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';

            $html.="<script>
                $(document).ready(function(){

                    $('.filter_program_start_date, .filter_program_end_date').change(function () {

                        var program_start_date = new Date($('.filter_program_start_date').val());
                        var program_end_date = new Date($('.filter_program_end_date').val());

                        // Normalize time
                        program_start_date.setHours(0, 0, 0, 0);
                        program_end_date.setHours(0, 0, 0, 0);

                        $(this).parent().parent().parent().find('.entry_card').each(function () {

                            var entry_start_date = new Date($.trim($(this).attr('program_start_date')));
                            entry_start_date.setHours(0, 0, 0, 0);

                            var entry_end_date = new Date($.trim($(this).attr('program_end_date')));
                            entry_end_date.setHours(0, 0, 0, 0);

                            // Date match
                            var is_from_date_set = !isNaN(program_start_date.getTime());
                            var is_to_date_set = !isNaN(program_end_date.getTime());

                            var match_date = true;

                            if (is_from_date_set && is_to_date_set) {
                                match_date = (entry_start_date >= program_start_date && entry_end_date <= program_end_date);
                            } else if (is_from_date_set) {
                                match_date = entry_start_date.getTime() >= program_start_date.getTime();
                            } else if (is_to_date_set) {
                                match_date = entry_end_date.getTime() <= program_end_date.getTime();
                            }

                            if (match_date) {
                                $(this).parent().removeClass('d-none');
                            } else {
                                $(this).parent().addClass('d-none');
                            }
                        });
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
                            }
                        });
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

                $categories=$entry->granteeCategories(json_decode($entry->grantee_categories_id, true) ?? []);
                foreach($categories as $category){
                    if(!in_array($category,$grantee_categories)){
                        $grantee_categories[]=$category;
                    }
                }

                if(!in_array($entry->granteeCountry->name,$grantee_countries)){
                    $grantee_countries[]=$entry->granteeCountry->name;
                }

            }

            $html.='<div class="filters" style="">
                <div class="filter">
                    <select class="filterDpd filter_grantee_category">
                        <option value="">Select theme</option>';
                        foreach($grantee_categories as $category){
                            $html.='<option '.$category.'>'.$category.'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="filter">
                    <select class="filterDpd filter_grantee_country">    
                        <option value="">Select country</option>';
                        foreach($grantee_countries as $country){
                            $html.='<option '.$country.'>'.$country.'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';
        }
        else if($collection_type_id==5) // Jurors
        {
            //Get categories and countries
            $juror_countries=[];
            
            foreach($entries as $entry){

                if(!in_array($entry->juryCountry?->name,$juror_countries)){
                    $juror_countries[]=$entry->juryCountry?->name;
                }

            }

            $html.='<div class="filters" style="">
                <div class="filter">
                    <select class="filterDpd filter_jury_category">    
                        <option value="">Select country</option>';
                        foreach($juror_countries as $country){
                            $html.='<option '.$country.'>'.$country.'</option>';
                        }
                    $html.='</select>
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';
        }
        else if($collection_type_id==6 || $collection_type_id==7) //Resources & News
        {

            $html.='<div class="filters" style="">
                <div class="filter">
                    <input type="date" name="from_date" class="filter_resource_from_date"  placeholder="From Date" />
                </div>
                <div class="filter">
                    <input type="date" name="from_date" class="filter_resource_from_date"  placeholder="To Date" />
                </div>
                <div class="sort">SORT DPD</div>
                <div class="clear"></div>
            </div>';
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