<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

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
    <link rel="stylesheet" href="{{asset('frontend/css/general.css')}}?v=11" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}?v=40">
    <link rel="stylesheet" href="{{ asset('frontend/css/elements.css') }}?v=36">
    
    @if(app()->getLocale()=='ar')
    <link rel="stylesheet" href="{{asset('frontend/css/arabic.css')}}?v=23" />
    @endif

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
                <a href="{{url('/')}}">
                    @if(@$pageName=='Home')
                    <span class="header-logo-title small ABCDiatypeBlack black desktopOnly" id="header-logo-title">
                        @if(app()->getLocale() == 'ar')
                            الصندوق العربي للثقافة والفنون
                        @else
                            Arab Fund for Arts and Culture
                        @endif
                    </span>
                    @endif
                    @include('components.animated-logo', ['inNavbar' => true , 'headerBgCode' => @$headerBgCode])
                </a>
            </div>
            <div class="header-nav">
                <div class="langBtn tiny">
                    <span class="tiny ABCDiatypeBlack clickable" onclick="setLang('en')">EN</span> / <span class="tiny ABCDiatypeBlack clickable" onclick="setLang('ar')">عربي</span>
                </div>
                <div class="menuBtn tiny ABCDiatypeBlack clickable" id="menuBtn">@if(app()->getLocale() == 'ar') القائمة @else Menu @endif</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <!--Menu-->
    <div class="menu" id="menu" style="background:{{ @$menuBgCode }};">
        <div class="topSpacer closeBtn tiny ABCDiatypeMedium clickable" id="closeBtn">@if(app()->getLocale() == 'ar') إغلاق @else Close @endif</div>
        
        {{--<div class="mt-5 menu-item-row">
            <a href="{{url('/')}}" class="menu-item-link">
                <span class="menu-item-shape">
                    <img src="{{asset('frontend/images/circle-shape.svg')}}" width="40" class="desktopOnly" />
                    <img src="{{asset('frontend/images/circle-shape.svg')}}" width="30" class="mobileOnly" />
                </span>
                <span class="menu-item-text bigger @if(app()->getLocale() == 'en') leftSpacer @else rightSpacer @endif">@if(app()->getLocale() == 'ar') الرئيسية @else Home @endif</span>
            </a>
        </div>--}}
        @php 
            $pages=getMenuPages(); 
            $shapes=['square-shape','circle-shape','diamond-shape'];
        @endphp
        <div class="mt-5">&nbsp;</div>
        @foreach($pages as $key=>$page)
            <div class="mt-3 menu-item-row">
                @if($page->id=='3') 
                 <a href="{{url('/projects')}}" class="menu-item-link">
                @else
                <a href="{{url('page',['id'=>$page->id,'name'=>$page->name])}}" class="menu-item-link">
                @endif
                    <span class="menu-item-shape">
                        <img src="{{asset('frontend/images/'.$shapes[$key % count($shapes)].'.svg')}}" width="{{ $shapes[$key % count($shapes)] == 'diamond-shape' ? 52 : 40 }}" class="desktopOnly" />
                        <img src="{{asset('frontend/images/'.$shapes[$key % count($shapes)].'.svg')}}" width="{{ $shapes[$key % count($shapes)] == 'diamond-shape' ? 39 : 30 }}" class="mobileOnly" />
                    </span>
                    <span class="menu-item-text bigger @if(app()->getLocale() == 'en') leftSpacer @else rightSpacer @endif">@if(app()->getLocale() == 'ar') {{$page->name_arabic}} @else {{$page->name}} @endif</span>
                </a>
            </div>
        @endforeach
        
    </div>

    <style>
        .menu-item-link {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: #000;
            overflow: visible;
        }

        .menu-item-shape {
            width: 56px;
            opacity: 1;
            --shape-hide-x: calc(-100% - 3px);
            margin-inline-end: -56px;
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            overflow: hidden;
            transition: margin-inline-end 0.55s ease;
        }

        /* In Arabic (dir="rtl") the flex order mirrors, so the shape needs to
           hide/reveal towards the opposite physical side as in LTR. */
        [dir="rtl"] .menu-item-shape {
            --shape-hide-x: calc(100% + 3px);
        }

        .menu-item-shape img {
            display: block;
            transform: translateX(var(--shape-hide-x));
            transition: transform 0.55s ease;
        }

        .menu-item-text {
            display: inline-block;
            --text-reveal-x: 6px;
            transform: translateX(0);
            transition: transform 0.55s ease;
        }

        [dir="rtl"] .menu-item-text {
            --text-reveal-x: -6px;
        }

        .menu-item-link:hover .menu-item-shape,
        .menu-item-link:focus-visible .menu-item-shape {
            margin-inline-end: 6px;
        }

        .menu-item-link:hover .menu-item-shape img,
        .menu-item-link:focus-visible .menu-item-shape img {
            transform: translateX(0);
        }

        .menu-item-link:hover .menu-item-text,
        .menu-item-link:focus-visible .menu-item-text {
            transform: translateX(var(--text-reveal-x));
        }

        @media (max-width: 900px) {
            .menu-item-shape {
                width: 34px;
                margin-inline-end: -34px;
            }

            .menu-item-link:hover .menu-item-shape,
            .menu-item-link:focus-visible .menu-item-shape {
                margin-inline-end: 14px;
            }
        }
    </style>
    
    <!--Page Content-->
    <div class="pageContent">
        @yield('content')
    </div>

    <!--popup-->
    <div class="popupEntry d-none">
        <div class="popupText">
            <div class="closeBtn"></div>
            <div class="medium black ABCDiatypeMedium" id="title"></div>
            <!-- <div class="mt-2 small black ABCDiatypeMedium" id="position"></div> -->
            <div class="mt-2 small black" id="text"></div>
        </div>
    </div>

    <!--Footer-->
    <div class="footer" style="background:{{@$footerBgCode}};">
        <div class="centerContainer">
            <div class="row">

                <div class="col-lg-3 col-12 mb-4 mb-md-0">
                    <img src="{{asset('frontend/images/logo.svg')}}" width="60%" />
                </div>

                @php
                    $isAr = app()->getLocale() === 'ar';
                    $footerCols = [
                        1 => [
                            'title' => $isAr ? (@$footer->col1_arabic ?? @$footer->col1) : (@$footer->col1 ?? ''),
                            'links' => $isAr ? (@$footer->col1_arabic_links ?? @$footer->col1_links ?? []) : (@$footer->col1_links ?? []),
                        ],
                        2 => [
                            'title' => $isAr ? (@$footer->col2_arabic ?? @$footer->col2) : (@$footer->col2 ?? ''),
                            'links' => $isAr ? (@$footer->col2_arabic_links ?? @$footer->col2_links ?? []) : (@$footer->col2_links ?? []),
                        ],
                        3 => [
                            'title' => $isAr ? (@$footer->col3_arabic ?? @$footer->col3) : (@$footer->col3 ?? ''),
                            'links' => $isAr ? (@$footer->col3_arabic_links ?? @$footer->col3_links ?? []) : (@$footer->col3_links ?? []),
                        ],
                    ];
                @endphp

                @foreach($footerCols as $col)
                    @if(!empty($col['title']) || !empty($col['links']))
                    <div class="col-lg-3 col-12 mb-4 mb-md-0">
                        @if(!empty($col['title']))
                            <div class="tiny black ABCDiatypeMedium">{{ $col['title'] }}</div>
                        @endif
                        @foreach((array)$col['links'] as $idx => $link)
                            <div class="{{ $idx === 0 ? 'mt-2' : 'mt-1' }}">
                                <a href="{{ $link['link'] ?? '#' }}" class="tiny black" @if(!empty($link['link']) && str_starts_with($link['link'], 'https')) target="_blank" rel="noopener noreferrer" @endif>{{ $link['title'] ?? '' }}</a>
                            </div>
                        @endforeach
                    </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        function setLang(locale) { 
            fetch('/set-language', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ locale: locale })
            }).then(() => location.reload());
        }

        // Header: sentence first, animated logo after scroll
        (function () {
            var logoTitle = document.getElementById('header-logo-title');
            var logoNav = document.getElementById('animated-logo-root-nav');
            if (!logoTitle || !logoNav) return;

            // Scroll position after which the header logo appears: the end of the section holding the main animated logo
            function getThreshold() {
                var mainLogo = document.getElementById('animated-logo-root');
                if (!mainLogo) return 50;
                var section = mainLogo.closest('.section') || mainLogo;
                var headerEl = document.querySelector('.header');
                var headerH = headerEl ? headerEl.offsetHeight : 0;
                var bottom = section.getBoundingClientRect().bottom + window.scrollY;
                return Math.max(50, bottom - headerH);
            }

            function syncHeaderLogo() {
                var isMobile = window.innerWidth <= 1000;
                var passed = window.scrollY > getThreshold();
                if (isMobile) {
                    logoTitle.style.display = 'none';
                    logoNav.style.display = passed ? 'block' : 'none';
                } else if (passed) {
                    logoTitle.style.display = 'none';
                    logoNav.style.display = 'block';
                } else {
                    logoTitle.style.display = '';
                    logoNav.style.display = 'none';
                }
            }

            logoNav.style.display = 'none';
            syncHeaderLogo();
            window.addEventListener('scroll', syncHeaderLogo, { passive: true });
            window.addEventListener('resize', syncHeaderLogo, { passive: true });
        })();

        $(document).ready(function () {
            const menuDirection = "{{ app()->getLocale() == 'en' ? 'right' : 'left' }}";

            $("#menuBtn").on("click", function () {
                let animation = {};
                animation[menuDirection] = "0px";

                $("#menu").animate(animation, 600);
            });

            $("#closeBtn").on("click", function () {
                let animation = {};
                animation[menuDirection] = "-100%";

                $("#menu").animate(animation, 600);
            });
        });

    </script>

</body>
        
</html>