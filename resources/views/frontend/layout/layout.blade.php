<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('frontend/images/favicon.png')}}" />

    @php
        $title = ucwords(str_replace('.', '-', request()->route()->getName()));
        $title = ucwords(str_replace('-', ' ', $title));
    @endphp

    @yield('title-meta')

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/plugins.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>

<body>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $(document).ready(function() { 

            
        });

    </script>


</body>
        
</html>