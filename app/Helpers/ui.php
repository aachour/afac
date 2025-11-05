<?php

    use App\Models\Collections;
    use App\Models\Entries;

    function ViewCollection($collectionId)
    {

        $collection=Collections::find($collectionId);

        $html='<div class="">';

        
        $html.='</div>';
        
        return $html;
        
    }

?>
