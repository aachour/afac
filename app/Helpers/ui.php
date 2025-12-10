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
    

    function ViewCollection($collection_id,$language='EN')
    {

        $collection=Collections::find($collection_id);

        if($collection==null){
            return '';
        }

        $collection_type_id=$collection->type_id;
        $show_name=$collection->show_name;
        $show_description=$collection->show_description;
        $show_view_all=$collection->show_view_all;
        $view_all_title=$collection->view_all_title;
        $view_all_link=$collection->view_all_link;
        $with_border_bottom=$collection->with_border_bottom;
        $entries_selection=$collection->entries_selection;
        $entries_per_row=$collection->entries_per_row;
        $entries_layout=$collection->entries_layout;
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

            $query = Entries::where('type_id', $collection_type_id);

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

        $bgColor = $collection->bgColor?->code ?? '#ffffff';
        
        $sliderCollection = $entries_layout == 2 ? 'sliderCollection' : '';
        

        $html='<div class="collection '.$sliderCollection.'" style="background-color:'.$bgColor.';">';

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

                        if($collection_type_id==1){
                            $entry_title=$entry->event_title;
                            $entry_text=$entry->event_text;
                            $entry_href=$entry->id;
                            $entry_target='';
                        }
                        else if($collection_type_id==2){
                            $entry_title=$entry->program_title;
                            $entry_text=$entry->program_text;
                            $entry_href=$entry->id;
                            $entry_target='';
                        }
                        else if($collection_type_id==3){
                            $entry_title=$entry->project_title;
                            $entry_text=$entry->project_text;
                            $entry_href=$entry->id;
                            $entry_target='';
                        }
                        else if($collection_type_id==4){
                            $entry_title=$entry->grantee_name;
                            $entry_text=$entry->grantee_text;
                            $entry_href=$entry->id;
                            $entry_target='';
                        }
                        else if($collection_type_id==5){
                            $entry_title=$entry->jury_name;
                            $entry_text=$entry->jury_text;
                            $entry_href=$entry->id;
                            $entry_target='';
                        }
                        else if($collection_type_id==6){
                            $entry_title=$entry->resource_title;
                            $entry_text=$entry->resource_text;
                            $entry_href=$entry->id;
                            $entry_target='';
                        }
                        else if($collection_type_id==7){
                            $entry_title=$entry->news_title;
                            $entry_text=$entry->news_text;
                            $entry_href=$entry->id;
                            $entry_target='';
                        }
                        else if($collection_type_id==8){
                            $entry_title=$entry->external_title;
                            $entry_text=$entry->external_text;
                            $entry_href=$entry->external_link;
                            $entry_target='_blank';
                        }

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
                                            $html.='<div class="title_or_labels threeQuartersText" style="'.$labels_position.'">
                                                <div class="label micro ABCDiatypeMedium">'.$entries[0]->type->name.'</div>';
                                                if($collection_type_id==1){
                                                    $html.='<div class="label micro rounded ABCDiatypeMedium">'.date('d M',strtotime($entries[0]->event_date)).'</div>
                                                    <div class="label micro rounded ABCDiatypeMedium">'.date('h:i',strtotime($entries[0]->event_start_time)).' - '.date('h:i',strtotime($entries[0]->event_to_time)).'</div>
                                                    <div class="clear">&nbsp;</div>';
                                                }
                                            $html.='</div>';
                                        }
                                    $html.='</div>
                                    <div class="featured_image">
                                        <img src="'.$image_path.'" width="100%" />
                                    </div>
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
                                                if($collection_type_id==1){
                                                    $html.='<div class="label micro black ABCDiatypeMedium">'.date('d M',strtotime($entries[0]->event_date)).'</div>
                                                    <div class="clear"></div>
                                                    <div class="topSpacerSmall label micro black ABCDiatypeMedium">'.date('h:i',strtotime($entries[0]->event_start_time)).' - '.date('h:i',strtotime($entries[0]->event_to_time)).'</div>
                                                    <div class="clear">&nbsp;</div>';
                                                }
                                            $html.='</div>';
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

                            if($collection_type_id==1){
                                $entry_title=$entry->event_title;
                                $entry_href=$entry->id;
                                $entry_target='';
                            }
                            else if($collection_type_id==2){
                                $entry_title=$entry->program_title;
                                $entry_href=$entry->id;
                                $entry_target='';
                            }
                            else if($collection_type_id==3){
                                $entry_title=$entry->project_title;
                                $entry_href=$entry->id;
                                $entry_target='';
                            }
                            else if($collection_type_id==4){
                                $entry_title=$entry->grantee_name;
                                $entry_href=$entry->id;
                                $entry_target='';
                            }
                            else if($collection_type_id==5){
                                $entry_title=$entry->jury_name;
                                $entry_href=$entry->id;
                                $entry_target='';
                            }
                            else if($collection_type_id==6){
                                $entry_title=$entry->resource_title;
                                $entry_href=$entry->id;
                                $entry_target='';
                            }
                            else if($collection_type_id==7){
                                $entry_title=$entry->news_title;
                                $entry_href=$entry->id;
                                $entry_target='';
                            }
                            else if($collection_type_id==8){
                                $entry_title=$entry->external_title;
                                $entry_href=$entry->external_link;
                                $entry_target='_blank';
                            }

                            $html.='<div class="swiper-slide entry">
                                
                                <a href="'.$entry_href.'" target="'.$entry_target.'">
                                    <img src="'.$image_path.'" width="100%" />
                                    <div class="description">
                                        <div class="title_or_labels medium white ABCDiatypeMedium" style="'.$title_position.'">'.$entry_title.'</div>';
                                        if($with_label==1)
                                        {
                                            $html.='<div class="title_or_labels" style="'.$labels_position.'">
                                                <div class="label micro black ABCDiatypeMedium">'.$entry->type->name.'</div>';
                                                if($collection_type_id==1){
                                                    $html.='<div class="label micro black rounded ABCDiatypeMedium">'.date('d M',strtotime($entry->event_date)).'</div>
                                                    <div class="clear"></div>
                                                    <div class="topSpacerSmall label micro black rounded ABCDiatypeMedium">'.date('h:i',strtotime($entry->event_start_time)).' - '.date('h:i',strtotime($entry->event_to_time)).'</div>
                                                    <div class="clear">&nbsp;</div>';
                                                }
                                            $html.='</div>';
                                        }
                                    $html.='</div>
                                </a>
                                    
                            </div>';

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

        if($with_border_bottom == 1){
            $html.='<div class="collectionWithBorder"></div>';
        }

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


    function ViewColumnGeneral($section_column_id,$language='EN'){

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
                            <a href="' . ($generalInput->button_link ?? '#') . '">
                                <button class="'.strtolower($generalInput->shape->name).' medium black ABCDiatypeMedium" style="background:'.$generalInput->buttonBgColor->code.';">'.$generalInput->button_value.'</button>
                            </a>
                        </div>';
                    }

                }

                $htmlColumn.='</div>

            </div>';

        }

        return $htmlColumn;

    }


    function ViewTimeline($section_column_id,$language='EN'){

        $htmlColumn='';

        $column=SectionColumns::with('timelines')->find($section_column_id);

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

                                    <div class="col-lg-9 col-12">';

                                        //get all text inside this timeline
                                        foreach($timeline->percentages as $key=>$percentage){

                                            $htmlColumn.='<div class="percentage '.($key == '0' ? '' : 'd-none').'">

                                                <div class="big black">'.$percentage->text.'</div>'; 
                                                
                                                if($percentage->percentage!=0){
                                                    for($i=1;$i<=10;$i++){
                                                        for($j=1;$j<=10;$j++){
                                                            $htmlColumn.='<img src="'.asset('frontend/images/diamond.png').'" width="10%" />';
                                                        }  
                                                        $htmlColumn.='<br />';
                                                    }
                                                }
                                            
                                            $htmlColumn.='</div>';
                                        }
                                    
                                    $htmlColumn.='</div>
                                </div>
                            </div>';

                        }

                        $htmlColumn.='<div class="verticalLine"></div>

                    </div>

                </div>

            </div>';

        }

        return $htmlColumn;

    }


    function ViewAccordion($section_column_id,$language='EN'){

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
                        <div class="accordionArrow clickable" status="'.($key == '0' ? '1' : '0').'">
                            <img src="'.asset('frontend/images/'.($key == '0' ? 'arrow-up.png' : 'arrow-down.png')).'" width="30px" />
                        </div>
                        <div class="clear"></div>
                        <div class="accordionText mt-2 small black '.($key == '0' ? '' : 'd-none').' ">'.$accordion->text.'</div>
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
                        $(this).find("img").attr("src","'.asset("frontend/images/arrow-down.png").'");
                        $(this).parent().find(".accordionText").removeClass("d-none");
                        $(this).attr("status","1");
                    }
                    else{
                        $(this).find("img").attr("src","'.asset("frontend/images/arrow-up.png").'");
                        $(this).parent().find(".accordionText").addClass("d-none");
                        $(this).attr("status","0");
                    }
                });
            });
        </script>';

        return $htmlColumn;

    }


    function ViewCountdown($section_column_id,$language='EN'){

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

                    $start_date=$countdown->start_date;
                    $end_date=$countdown->end_date;
                    $start_time=$countdown->start_time;
                    $end_time=$countdown->end_time;

                    $start = new DateTime("$start_date $start_time");
                    $end   = new DateTime("$end_date $end_time");

                    $diff = $start->diff($end);

                    $htmlColumn.= '<div class="coutdown">
                    
                        <div class="medium black ABCDiatypeMedium">'.$countdown->title.'</div>

                        <div class="row mt-5 align-items-center">
                            <div class="mt-4 col-12 col-lg-4 text-center text-lg-end">
                                <div class="huge black ABCDiatypeMedium">'.$diff->days.'</div>
                                <div class="big black ABCDiatypeMedium">Day(s)</div>
                            </div>
                            <div class="mt-4 col-12 col-lg-4 text-center">
                                <a href="'.($countdown->button_link ?? '#').'">
                                    <button class="circle small ABCDiatypeMedium">'.$countdown->button_value.'</button>
                                </a>
                            </div>
                            <div class="mt-4 col-12 col-lg-4 text-center text-lg-start ">
                                <div class="huge black ABCDiatypeMedium">'.$diff->h.'</div>
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


    function ViewExpandingText($section_column_id,$language='EN'){

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

                    $htmlColumn.= '<div class="expandingText mb-3 small black ABCDiatypeMedium '.($expandingText->visible == '1' ? '' : 'hiddenText d-none').'">'.$expandingText->text.'</div>';

                }

                $htmlColumn.='</div>

            </div>';

        }

        //add script
        $htmlColumn.='<script>

            function showExpandingText(callback){
                const items = $(".hiddenText");

                items.each(function(i){
                    let el = $(this);

                    setTimeout(() => {
                        el.removeClass("d-none");

                        // When the last element is shown → call callback
                        if (i === items.length - 1 && callback) {
                            callback();
                        }
                    }, i * 1000); // delay between each item (500ms)
                });
            }

            function hideExpandingText(){
                $(".hiddenText").addClass("d-none");
            }
            
            $(document).ready(function(){

                function loop(){
                    showExpandingText(() => {
                        setTimeout(() => {
                            hideExpandingText();

                            // Step 3: Wait again then restart the loop
                            setTimeout(loop, 2000);

                        }, 5000);
                    });
                }

                loop();
                
            });
        </script>';

        return $htmlColumn;

    }

?>