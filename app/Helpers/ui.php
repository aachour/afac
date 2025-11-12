<?php

    use App\Models\Collections;
    use App\Models\CollectionEntries;
    use App\Models\Entries;

    function ViewCollection($collection_id,$language='EN')
    {

        $collection=Collections::find($collection_id);

        if($collection==null){
            return '';
        }

        $collection_type_id=$collection->type_id;
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
            $featured_width='79.5%';
            $featured_margin='20.5%';
        }
        else if($featured_image_width==3) //one half
        {
            $featured_width='50%';
            $featured_margin='50%';
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
        
        $html='<div class="collection" style="background-color:'.$bgColor.';">';

            $html.='<div class="white big ABCDiatypeMedium">'.$collection->name.'</div>';

            if(count($entries)>0)
            {

                //show featured entry on top
                if($with_featured==1) 
                { 
                    $image_path = asset('frontend/images/default-image.jpg');
                    if (!empty($entries[0]->image)) {
                        $image_path = asset('storage/' . $entries[0]->image_featured);
                    }

                    $html.='<div class="desktopOnly">
                        <div class="topSpacer featured_entry" style="background:'.$featured_image_bgColor.'; width:'.$featured_width.'; margin-left:'.$featured_margin.';">
                            <div class="featured_info">
                                <div class="title_or_labels" style="'.$title_position.'">
                                    <div class="medium white ABCDiatypeMedium">'.$entries[0]->event_title.'</div>
                                    <div class="topSpacerSmall tiny white threeQuartersText">'.$entries[0]->event_text.'</div>
                                </div>';
                                if($with_label==1)
                                {
                                    $html.='<div class="title_or_labels threeQuartersText" style="'.$labels_position.'">
                                        <div class="label micro ABCDiatypeMedium">'.$entries[0]->type->name.'</div>
                                        <div class="label micro ABCDiatypeMedium rounded">'.date('d M',strtotime($entries[0]->event_date)).'</div>
                                        <div class="label micro rounded ABCDiatypeMedium">'.date('h:i',strtotime($entries[0]->event_start_time)).' - '.date('h:i',strtotime($entries[0]->event_to_time)).'</div>
                                        <div class="clear">&nbsp;</div>
                                    </div>';
                                }
                            $html.='</div>
                            <div class="featured_image">
                                <img src="'.$image_path.'" width="100%" />
                            </div>
                        </div>
                    </div>';


                    $html.='<div class="entries mobileOnly">
                        <div class="featured_entry_mobile" style="background:'.$featured_image_bgColor.';">
                           <img src="'.$image_path.'" width="100%" />
                            <div class="description">
                                <div class="title_or_labels medium white ABCDiatypeMedium" style="'.$title_position.'">'.$entries[0]->event_title.'</div>
                                <div class="topSpacerSmall tiny white">'.$entries[0]->event_text.'</div>';
                                if($with_label==1)
                                {
                                    $html.='<div class="title_or_labels" style="'.$labels_position.'">
                                        <div class="label micro black ABCDiatypeMedium">'.$entries[0]->type->name.'</div>
                                        <div class="label micro black ABCDiatypeMedium">'.date('d M',strtotime($entries[0]->event_date)).'</div>
                                        <div class="clear"></div>
                                        <div class="topSpacerSmall label micro black ABCDiatypeMedium">'.date('h:i',strtotime($entries[0]->event_start_time)).' - '.date('h:i',strtotime($entries[0]->event_to_time)).'</div>
                                        <div class="clear">&nbsp;</div>
                                    </div>';
                                }
                            $html.='</div>
                            
                        </div>
                    </div>';

                    
                }

                $html.='<div class="entries topSpacerBig">';
                    
                    $entries_count=0;

                    //Open slider
                    if($entries_layout==2) 
                    {

                        $html.='<style>
                            .collection .entries .entry:nth-child(5n){
                                margin-right:20px !important;
                            }
                        </style>';

                        $html.='<div class="swiper" style="width:102.5%;">
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

                        $html.='<div class="swiper-slide entry">

                            <img src="'.$image_path.'" width="100%" />
                            <div class="description">
                                <div class="title_or_labels medium white ABCDiatypeMedium" style="'.$title_position.'">'.$entry->event_title.'</div>';
                                if($with_label==1)
                                {
                                    $html.='<div class="title_or_labels" style="'.$labels_position.'">
                                        <div class="label micro black ABCDiatypeMedium">'.$entry->type->name.'</div>
                                        <div class="label micro black rounded ABCDiatypeMedium">'.date('d M',strtotime($entry->event_date)).'</div>
                                        <div class="clear"></div>
                                        <div class="topSpacerSmall label micro black rounded ABCDiatypeMedium">'.date('h:i',strtotime($entry->event_start_time)).' - '.date('h:i',strtotime($entry->event_to_time)).'</div>
                                        <div class="clear">&nbsp;</div>
                                    </div>';
                                }
                            $html.='</div>
                                
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
                slidesPerView: 5.11,  
                spaceBetween: 20,
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
                    slidesPerView: 5.13,
                    spaceBetween: 22
                },
            }
            });
        </script>';
        
        return $html;

    }

    function ViewCollection2($collection_id,$language='EN')
    {

        $collection=Collections::find($collection_id);

        if($collection==null){
            return '';
        }

        $collection_type_id=$collection->type_id;
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
        else if($featured_image_width==3) //one half
        {
            $featured_width='50%';
            $featured_margin='50%';
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
        
        $html='<div class="collection" style="background-color:'.$bgColor.';">';

            $html.='<div class="white big ABCDiatypeMedium">'.$collection->name.'</div>';

            if(count($entries)>0)
            {

                //show featured entry on top
                if($with_featured==1) 
                { 
                    $image_path = asset('frontend/images/default-image.jpg');
                    if (!empty($entries[0]->image)) {
                        $image_path = asset('storage/' . $entries[0]->image_featured);
                    }

                    $html.='<div class="desktopOnly">
                        <div class="topSpacer featured_entry" style="background:'.$featured_image_bgColor.'; width:'.$featured_width.'; margin-left:'.$featured_margin.';">
                            <div class="featured_info">
                                <div class="title_or_labels" style="'.$title_position.'">
                                    <div class="medium white ABCDiatypeMedium">'.$entries[0]->event_title.'</div>
                                    <div class="topSpacerSmall tiny white threeQuartersText">'.$entries[0]->event_text.'</div>
                                </div>';
                                if($with_label==1)
                                {
                                    $html.='<div class="title_or_labels threeQuartersText" style="'.$labels_position.'">
                                        <div class="label micro ABCDiatypeMedium">'.$entries[0]->type->name.'</div>
                                        <div class="label micro rounded ABCDiatypeMedium">'.date('d M',strtotime($entries[0]->event_date)).'</div>
                                        <div class="label micro rounded ABCDiatypeMedium">'.date('h:i',strtotime($entries[0]->event_start_time)).' - '.date('h:i',strtotime($entries[0]->event_to_time)).'</div>
                                        <div class="clear">&nbsp;</div>
                                    </div>';
                                }
                            $html.='</div>
                            <div class="featured_image">
                                <img src="'.$image_path.'" width="100%" />
                            </div>
                        </div>
                    </div>';


                    $html.='<div class="entries mobileOnly">
                        <div class="featured_entry_mobile" style="background:'.$featured_image_bgColor.';">
                           <img src="'.$image_path.'" width="100%" />
                            <div class="description">
                                <div class="title_or_labels medium white ABCDiatypeMedium" style="'.$title_position.'">'.$entries[0]->event_title.'</div>';
                                if($with_label==1)
                                {
                                    $html.='<div class="title_or_labels" style="'.$labels_position.'">
                                        <div class="label micro black ABCDiatypeMedium">'.$entries[0]->type->name.'</div>
                                        <div class="label micro black ABCDiatypeMedium">'.date('d M',strtotime($entries[0]->event_date)).'</div>
                                        <div class="clear"></div>
                                        <div class="topSpacerSmall label micro black ABCDiatypeMedium">'.date('h:i',strtotime($entries[0]->event_start_time)).' - '.date('h:i',strtotime($entries[0]->event_to_time)).'</div>
                                        <div class="clear">&nbsp;</div>
                                    </div>';
                                }
                            $html.='</div>
                            
                        </div>
                    </div>';

                    
                }

                $html.='<div class="entries2 topSpacerBig">';
                    
                    $entries_count=0;

                    //Open slider
                    if($entries_layout==2) 
                    {

                        $html.='<style>
                            .collection .entries2 .entry:nth-child(4n){
                                margin-right:1.2% !important;
                            }
                        </style>';

                        $html.='<div class="swiper" style="width:102.5%;">
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

                        $html.='<div class="swiper-slide entry">

                            <img src="'.$image_path.'" width="100%" />
                            <div class="description">
                                <div class="title_or_labels medium white ABCDiatypeMedium" style="'.$title_position.'">'.$entry->event_title.'</div>';
                                if($with_label==1)
                                {
                                    $html.='<div class="title_or_labels" style="'.$labels_position.'">
                                        <div class="label micro black ABCDiatypeMedium">'.$entry->type->name.'</div>
                                        <div class="label micro black rounded ABCDiatypeMedium">'.date('d M',strtotime($entry->event_date)).'</div>
                                        <div class="clear"></div>
                                        <div class="topSpacerSmall label micro black rounded ABCDiatypeMedium">'.date('h:i',strtotime($entry->event_start_time)).' - '.date('h:i',strtotime($entry->event_to_time)).'</div>
                                        <div class="clear">&nbsp;</div>
                                    </div>';
                                }
                            $html.='</div>
                                
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

?>
