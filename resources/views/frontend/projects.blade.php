@extends('frontend.layout.layout')

@section('title-meta')
    <title>Projects | AFAC</title>
    <meta property="og:title" content="">
    <meta name="description" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:type" content="website">
@endsection

@section('content')

    <div class=""></div>

    <script>

        function getFilteredEntries(collection_id,filters=""){
            $("#collectionEntries-"+collection_id).empty();
            $("#loader").removeClass("d-none");
            $.ajax({
                url: "' . route('get.projects') . '",
                method: "POST",
                data: {
                    collection_id: collection_id,
                    entries_id: '.json_encode($entries_id ?? []).',
                    filters: filters,
                },
                success: function(response) {
                    $("#loader").addClass("d-none");
                    $("#collectionEntries-"+collection_id).html(response);
                },
                error: function(xhr) {
                    if(xhr.responseJSON && xhr.responseJSON.errors){
                        alert(JSON.stringify(xhr.responseJSON.errors));
                    }
                }
            });
        }

        $(document).ready(function(){ 
            let collection_id= '.$collection_id.'; 
            getFilteredEntries(collection_id);
            
        });

        </script>
    
@endsection
