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

        //Get All Entries

        $entries=null;

        if ($entries_selection == 1) // custom selection
        {
            $entries = CollectionEntries::where('collection_id', $collection_id)
                        ->with('entry')
                        ->orderBy('list_order', 'ASC')
                        ->get();
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

        dd($entries);

        $bgColor = $collection->bgColor?->code ?? '#ffffff';
        
        $html='<div class="collection" style="background-color:'.$bgColor.';">';

            $html.='<div class="">'.$collection->name.'</div>';

            if($entries){

                foreach($entries as $entry){

                }

            }

        $html.='</div>';
        
        return $html;

    }

?>
