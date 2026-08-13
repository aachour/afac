@extends('frontend.layout.layout')

@section('title-meta')

    <title>{{ $metaTitle }} | AFAC</title>
    <meta property="og:title" content="{!! $metaTitle !!}">
    <meta name="description" content="{!! $metaDescription !!}">
    <meta property="og:description" content="{!! $metaDescription !!}">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:type" content="website">

@endsection

@section('content')

    <style>
        .section-reveal-after-logo {
            opacity: 1;
            transform: none;
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .section-reveal-after-logo.is-hidden-before-logo {
            opacity: 0;
            transform: translateY(60px);
            pointer-events: none;
        }

        .section-reveal-after-logo.is-collapsed-before-logo {
            display: none;
        }

        .section-reveal-after-logo.is-revealed-after-logo {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
    </style>

    <div class="fullContainer">

        @if(@$logoAnimation==1)
            <div class="section">
                @include('components.animated-logo', ['logoElements' => $logoElements])
            </div>
        @endif

        @if(@$pageShowName==1)
            <div class="section" style="background:{{@$headerBgCode}};">
                <div class="bigger black ABCDiatype">{{ app()->getLocale() == 'ar' ? $pageNameArabic : $pageName }}</div>
            </div>
        @endif

        {!! $pageHTML !!}
    
    </div>

    @if(@$logoAnimation==1)
        <script>
            (function () {
                /*document.addEventListener('DOMContentLoaded', function () {
                    var fullContainer = document.querySelector('.fullContainer');
                    if (!fullContainer) return;

                    var sections = fullContainer.querySelectorAll(':scope > .section');
                    if (sections.length < 2) return;

                    var revealTarget = sections[1];
                    revealTarget.classList.add('section-reveal-after-logo', 'is-hidden-before-logo', 'is-collapsed-before-logo');

                    document.addEventListener('animatedLogo:minimized', function () {
                        revealTarget.classList.remove('is-collapsed-before-logo');
                        requestAnimationFrame(function () {
                            revealTarget.classList.remove('is-hidden-before-logo');
                            revealTarget.classList.add('is-revealed-after-logo');
                        });
                    }, { once: true });
                });*/
            })();
        </script>
    @endif
    
@endsection