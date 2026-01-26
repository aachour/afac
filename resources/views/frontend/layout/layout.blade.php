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
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/jquery-ui.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/swiper.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/general.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/elements.css')}}" />
    
    <!-- JS -->
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.js')}}"></script>
    <script src="{{asset('frontend/js/swiper.js')}}"></script>
    
        
</head>

<body>

    <!--Header-->
    <div class="header" style="background:{{@$headerBgCode}};">
        <div class="centerContainer">
            <div class="logo">
                <img src="{{asset('frontend/images/logo.svg')}}" width="100px" />
            </div>
            <div class="topSpacerSmall menu tiny ABCDiatypeMedium">Menu</div>
            <div class="topSpacerSmall lang rightSpacerBig tiny ABCDiatypeMedium">EN/AR</div>
            <div class="clear"></div>
        </div>
    </div>
    
    <!--Page Content-->
    <div class="pageContent mt-5 mb-5">
        @yield('content')
    </div>

    <!--Footer-->
    <div class="footer" style="background:{{@$footerBgCode}};">
        <div class="centerContainer">
            <div class="row">

                <div class="col-lg-3 col-12">
                    <img src="{{asset('frontend/images/logo.svg')}}" width="60%" />
                </div>

                <div class="col-lg-3 col-12">
                    <div class="small black ABCDiatypeMedium">About</div>
                    <div class="topSpacerSmaller">
                        <a href="#" class="tiny black">Mission & Vision</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">Board of Trustees</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">Team</a>
                    </div>
                </div>

                <div class="col-lg-3 col-12">
                    <div class="small black ABCDiatypeMedium">Get in Touch</div>
                    <div class="topSpacerSmaller">
                        <a href="#" class="tiny black">Contact</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">Facebook</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">Insta</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">X</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">Youtube</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">Linkedin</a>
                    </div>
                </div>

                <div class="col-lg-3 col-12">
                    <div class="small black ABCDiatypeMedium">Get Involved</div>
                    <div class="topSpacerSmaller">
                        <a href="#" class="tiny black">Support Us</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">Subscribe to Newsletter</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">Work With Us</a>
                    </div>
                    <div class="">
                        <a href="#" class="tiny black">Events</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

    </script>


</body>
        
</html>