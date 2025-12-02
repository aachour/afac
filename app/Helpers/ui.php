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
        
        $withBorder = $with_border_bottom == 1 ? 'collectionWithBorder' : '';

        $html='<div class="collection '.$withBorder.'" style="background-color:'.$bgColor.'; margin-bottom:40px;">';

            if($show_name==1 || $show_description==1){
                $html.='<div class="titleDescription">';
                    if($show_name==1){
                        $html.='<div class="black big ABCDiatypeMedium">'.$collection->name.'</div>';
                    }
                    if($show_description==1){
                        $html.='<div class="topSpacerSmall black tiny ABCDiatypeMedium">'.$collection->description.'</div>';
                    }
                $html.='</div>';
            }

            if($with_featured==0 || $show_view_all==1){
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

                    if($collection_type_id==1){
                        $entry_title=$entries[0]->event_title;
                        $entry_text=$entries[0]->event_text;
                        $entry_href=$entries[0]->id;
                        $entry_target='';
                    }
                    else if($collection_type_id==2){
                        $entry_title=$entries[0]->program_title;
                        $entry_text=$entries[0]->program_text;
                        $entry_href=$entries[0]->id;
                        $entry_target='';
                    }
                    else if($collection_type_id==3){
                        $entry_title=$entries[0]->project_title;
                        $entry_text=$entries[0]->project_text;
                        $entry_href=$entries[0]->id;
                        $entry_target='';
                    }
                    else if($collection_type_id==4){
                        $entry_title=$entries[0]->grantee_name;
                        $entry_text=$entries[0]->grantee_text;
                        $entry_href=$entries[0]->id;
                        $entry_target='';
                    }
                    else if($collection_type_id==5){
                        $entry_title=$entries[0]->jury_name;
                        $entry_text=$entries[0]->jury_text;
                        $entry_href=$entries[0]->id;
                        $entry_target='';
                    }
                    else if($collection_type_id==6){
                        $entry_title=$entries[0]->resource_title;
                        $entry_text=$entries[0]->resource_text;
                        $entry_href=$entries[0]->id;
                        $entry_target='';
                    }
                    else if($collection_type_id==7){
                        $entry_title=$entries[0]->news_title;
                        $entry_text=$entries[0]->news_text;
                        $entry_href=$entries[0]->id;
                        $entry_target='';
                    }
                    else if($collection_type_id==8){
                        $entry_title=$entries[0]->external_title;
                        $entry_text='';
                        $entry_href=$entries[0]->external_link;
                        $entry_target='_blank';
                    }

                    $image_path = asset('frontend/images/default-image.jpg');
                    if (!empty($entries[0]->image)) {
                        $image_path = asset('storage/' . $entries[0]->image_featured);
                    }

                    $html.='<a href="'.$entry_href.'" target="'.$entry_target.'">
                        <div class="desktopOnly">
                            <div class="topSpacer featured_entry" style="background:'.$featured_image_bgColor.'; width:'.$featured_width.'; margin-left:'.$featured_margin.';">
                                <div class="featured_info">
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


                    $html.='<a href="'.$entry_href.'" target="'.$entry_target.'">
                        <div class="entries mobileOnly">
                            <div class="featured_entry_mobile" style="background:'.$featured_image_bgColor.';">
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
                    
                }

                $html.='<div class="topSpacerBig entries">';
                    
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
                            .collection .entries .entry:nth-child(4n){
                                margin-right:1.2% !important;
                            }
                        </style>';

                        $html.='<div class="swiper" style="width:102.5%; padding-bottom:15px;">
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

                    $html.='<div class="clear">&nbsp;</div>';
                    
                    //Close Slider
                    if($entries_layout==2) 
                    {
                            $html.='</div">                             
                        </div>
                        <!-- Navigation buttons --> 
                        <div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>';
                    }

                $html.='</div>';

            }

        $html.='</div>';

        $html.='<script>
            const swiper = new Swiper(".swiper", {
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
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                // when window width is >= 992px
                900: {
                    slidesPerView: 4.12,
                    spaceBetween: 20
                },
            }
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

            $withBorder = $section->with_border_bottom == 1 ? 'sectionWithBorder' : '';

            $html='<div class="section '.$withBorder.'">

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

            return $html;

        }


    }


    function ViewColumnGeneral($section_column_id,$language='EN'){

        $htmlColumn='';

        $column=SectionColumns::with('generalInputs')->find($section_column_id);

        if($column){

            $textAlign = $column->alignment_id == 1 ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');

            $htmlColumn.='<div class="row '.$textAlign.'">

                <div class="col-lg-'.($column->width == 1 ? '12' : '9').' col-12">';

                foreach($column->generalInputs as $generalInput){

                    $input_type_id=$generalInput->input_type_id;

                    if($input_type_id==1)
                    {   //title
                        $htmlColumn.='<div class="topSpacerSmall big black ABCDiatypeMedium">'.$generalInput->title.'</div>';
                    }
                    else if($input_type_id==2)
                    {   //text
                        $htmlColumn.='<div class="topSpacerSmall small black ABCDiatype">'.$generalInput->text.'</div>';
                    }
                    else if($input_type_id==3)
                    {   //gallery
                        $galleryImages=$generalInput->gallery->images;
                        if(count($galleryImages)==1){ //single image
                            $htmlColumn.='<div class="topSpacerSmall"><img src='.asset("storage/".$galleryImages[0]->image_path).' /></div>';
                        }
                        else{ //gallery images
                            foreach($galleryImages as $galleryImage){
                                $htmlColumn.='<div class="topSpacerSmall"><img src='.asset("storage/".$galleryImage->image_path).' /></div>';
                                break;
                            }
                        }
                    }
                    else if($input_type_id==4)
                    {   //video
                        $htmlColumn.='<div class="topSpacer"><iframe src="'.$generalInput->video.'" height="400px"></iframe></div>';
                    }
                    else if($input_type_id==5)
                    {   //button

                        $textAlign = $generalInput->button_link == null ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');
                        
                        $htmlColumn.='<div class="topSpacerBig">
                            <a href="' . ($generalInput->button_link ?? '#') . '">
                                <button class="'.strtolower($generalInput->shape->name).' small black" style="background:'.$generalInput->buttonBgColor->code.';">'.$generalInput->button_value.'</button>
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

            $htmlColumn.='<div class="row '.$textAlign.'">

                <div class="col-lg-'.($column->width == 1 ? '12' : '9').' col-12">';

                foreach($column->timelines as $timeline){

                    $htmlColumn.= $timeline->date;

                }

                $htmlColumn.='</div>

            </div>';

        }

        return $htmlColumn;

    }


    function ViewAccordion($section_column_id,$language='EN'){

        $htmlColumn='';

        $column=SectionColumns::with('accordions')->find($section_column_id);

        if($column){

            $textAlign = $column->alignment_id == 1 ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');

            $htmlColumn.='<div class="row '.$textAlign.'">

                <div class="col-lg-'.($column->width == 1 ? '12' : '9').' col-12">';

                foreach($column->accordions as $accordion){

                    $htmlColumn.= '<div class="topSpacerSmall medium black ABCDiatypeMedium">'.$accordion->title.'</div>';
                    $htmlColumn.= '<div class="topSpacerSmaller small black">'.$accordion->text.'</div>';
                }

                $htmlColumn.='</div>

            </div>';

        }

        return $htmlColumn;

    }


    function ViewCountdown($section_column_id,$language='EN'){

        $htmlColumn='';

        $column=SectionColumns::with('countdowns')->find($section_column_id);

        if($column){

            $textAlign = $column->alignment_id == 1 ? 'text-left' : ($column->alignment_id == 2 ? 'text-right' : 'text-center');

            $htmlColumn.='<div class="row '.$textAlign.'">

                <div class="col-lg-'.($column->width == 1 ? '12' : '9').' col-12">';

                foreach($column->countdowns as $countdown){

                    $htmlColumn.= $countdown->title;

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

            $htmlColumn.='<div class="row '.$textAlign.'">

                <div class="col-lg-'.($column->width == 1 ? '12' : '9').' col-12">';
                foreach($column->expandingTexts as $expandingText){

                    $htmlColumn.= '<div class="topSpacerSmall medium black ABCDiatypeMedium '.($expandingText->visible == '1' ? '' : 'd-none').'">'.$expandingText->text.'</div>';

                }

                $htmlColumn.='</div>

            </div>';

        }

        return $htmlColumn;

    }

?>