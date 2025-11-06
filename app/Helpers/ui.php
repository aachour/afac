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
            $featured_width='75%';
            $featured_margin='25%';
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

        $entries=null;

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
            if ($entries_expired == 1 && $collection_type_id == 1) {
                $query->where('event_date', '>=', date('Y-m-d'));
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

        $bgColor = $collection->bgColor?->code ?? '#ffffff';
        
        $html='<div class="collection" style="background-color:'.$bgColor.';">';

            $html.='<div class="white bigger">'.$collection->name.'</div>';

            if($entries)
            {

                $html.='<div class="topSpacer">';

                    foreach($entries as $key=>$entry)
                    {

                        $image_path = asset('frontend/images/default-image.jpg');
                        if (!empty($entry->image)) {
                            $image_path = asset('storage/entries/' . $entry->image);
                        }

                        if($with_featured==1 && $key==0) //show featured entry on top
                        { 
                            $html.='<div class="featured_entry" style="background:'.$featured_image_bgColor.'; width:'.$featured_width.'; margin-left:'.$featured_margin.';">
                                <div class="featured_info">
                                    <div class="title_or_labels big white" style="'.$title_position.'">'.$entry->event_title.'</div>';
                                    if($with_label==1)
                                    {
                                        $html.='<div class="title_or_labels" style="'.$labels_position.'">
                                            <div class="label small">'.$entry->type->name.'</div>
                                            <div class="label small">'.date('d M',strtotime($entry->event_date)).'</div>
                                            <div class="clear"></div>
                                            <div class="topSpacerSmall label small">'.date('h:i',strtotime($entry->event_start_time)).' - '.date('h:i',strtotime($entry->event_to_time)).'</div>
                                            <div class="clear">&nbsp;</div>
                                        </div>';
                                    }
                                $html.='</div>
                                <div class="featured_image" style="background:url('.$image_path.') center no-repeat; background-size:cover;"></div>
                                <div class="clear"></div>
                            </div>
                            <div class="topSpacer">&nbsp;</div>';
                            
                            continue;
                        }

                        if($entries_layout==1) //grid view
                        {
                            $html.='<div class="entry">

                                <img src="'.$image_path.'" />
                                <div class="description">
                                    <div class="title_or_labels big white" style="'.$title_position.'">'.$entry->event_title.'</div>';
                                    if($with_label==1)
                                    {
                                        $html.='<div class="title_or_labels" style="'.$labels_position.'">
                                            <div class="label small black">'.$entry->type->name.'</div>
                                            <div class="label small black">'.date('d M',strtotime($entry->event_date)).'</div>
                                            <div class="clear"></div>
                                            <div class="topSpacerSmall label small black">'.date('h:i',strtotime($entry->event_start_time)).' - '.date('h:i',strtotime($entry->event_to_time)).'</div>
                                            <div class="clear">&nbsp;</div>
                                        </div>';
                                    }
                                $html.='</div>
                                
                            </div>';
                        }

                        /*else if($entries_layout==2) //slider view
                        {

                        }*/
                    }

                    $html.='<div class="clear">&nbsp;</div>';

                $html.='</div>';

            }

        $html.='</div>';
        
        return $html;

    }

?>
