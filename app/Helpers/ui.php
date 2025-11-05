<?php

    use App\Models\Collections;
    use App\Models\Entries;

    function ViewCollection($collectionId,$language='EN')
    {

        $collection=Collections::find($collectionId);

        if($collection==null){
            return '';
        }

        $bgColor = $collection->bgColor?->code ?? '#ffffff';
        
        $html='<div class="collection" style="background-color:'.$bgColor.';">';

            $html.='<div class="">'.$collection->name.'</div>';

        $html.='</div>';
        
        return $html;

    }

?>
