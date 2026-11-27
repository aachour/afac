@extends('frontend.layout.layout')

@section('title-meta')
    <title>Search{{ $term !== '' ? ': ' . $term : '' }} | AFAC</title>
    <meta name="robots" content="noindex">
    <meta property="og:type" content="website">
@endsection

@section('content')

    @php $isAr = app()->getLocale() == 'ar'; @endphp

    <style>
        @media(min-width:1000px){
            .collection .entries > .entry:nth-child(4n of .entry){
                {{ $isAr ? 'margin-left' : 'margin-right' }}:0 !important;
            }
        }
    </style>

    <div class="collection">

        <div id="search_title" class="big black mt-5">
            @if($term === '')
                {{ $isAr ? 'يرجى إدخال كلمة للبحث.' : 'Please enter a search term.' }}
            @elseif($isAr)
                تشاهد الآن <u class="big">{{ $totalResults }}</u> نتيجة لـ "<u class="big">{{ $term }}</u>".
            @else
                You are viewing <u class="big">{{ $totalResults }}</u> results for "<u class="big">{{ $term }}</u>".
            @endif
        </div>

        @foreach($sections as $key => $section)
            <div class="mt-5 search-section" id="{{ $key }}" data-section="{{ $key }}">
                <div class="medium black ABCDiatype mb-3">
                    {{ $section['title'] }} ({{ $section['total'] }})
                </div>

                <div class="entries search-entries">
                    {!! $section['cards'] !!}
                    <div class="clear"></div>
                </div>
                <div class="mt-5 text-center d-none search-loader"><div class="loader"></div></div>

                @if($section['pages'] > 1)
                    {{-- Same markup/behaviour as /projects: 3 page numbers visible, arrows slide the window by 3. --}}
                    <div class="mt-5 pagination-wrapper">
                        <div class="pagination">
                            <span class="nav-btn prev disabled">{!! $isAr ? '&rarr;' : '&larr;' !!}</span>
                            <div class="pages" style="display:flex; gap:8px;">
                                @for($p = 1; $p <= $section['pages']; $p++)
                                    <a href="javascript:void(0)" class="page-link page-item{{ $p == 1 ? ' active' : '' }}" data-page="{{ $p }}">{{ $p }}</a>
                                @endfor
                            </div>
                            <span class="nav-btn next">{!! $isAr ? '&larr;' : '&rarr;' !!}</span>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

        @if($term !== '' && $totalResults == 0)
            <div class="mt-5 black">
                {{ $isAr ? 'لم يتم العثور على نتائج.' : 'No results found.' }}
            </div>
        @endif

    </div>

    <script>
        var searchTerm = @json($term);

        // Show 3 page numbers starting at `start`, like the /projects pagination.
        function showPagesFrom($wrapper, start) {
            var $links = $wrapper.find('.page-link');
            var total = $links.length;
            start = Math.max(1, Math.min(start, total));
            $wrapper.data('start', start);
            $links.hide().filter(function () {
                var p = parseInt($(this).data('page'));
                return p >= start && p <= start + 2;
            }).show();
            $wrapper.find('.prev').toggleClass('disabled', start <= 1);
            $wrapper.find('.next').toggleClass('disabled', start + 2 >= total);
        }

        // Load one page of a section (offset/limit on the server) and replace only its entries.
        function getSearchSection($section, page) {
            var $entries = $section.find('.search-entries');
            var $loader = $section.find('.search-loader');

            $entries.empty();
            $loader.removeClass('d-none');

            $.ajax({
                url: "{{ route('get.search') }}",
                method: "POST",
                data: {
                    term: searchTerm,
                    section: $section.data('section'),
                    page: page,
                },
                success: function (response) {
                    $loader.addClass('d-none');
                    $entries.html(response + '<div class="clear"></div>');
                    $('html, body').animate({ scrollTop: $section.offset().top - 100 }, 200);
                },
                error: function () {
                    $loader.addClass('d-none');
                    $entries.html('<div class="black">{{ $isAr ? 'حدث خطأ، يرجى المحاولة مرة أخرى.' : 'Something went wrong, please try again.' }}</div>');
                }
            });
        }

        $(document).ready(function () {
            $('.search-section .pagination-wrapper').each(function () {
                showPagesFrom($(this), 1);
            });

            // Arrows only slide the visible page numbers (no loading).
            $('.search-section').on('click', '.nav-btn', function () {
                if ($(this).hasClass('disabled')) return;
                var $w = $(this).closest('.pagination-wrapper');
                showPagesFrom($w, $w.data('start') + ($(this).hasClass('next') ? 3 : -3));
            });

            // Page number: load that page's entries for this section only.
            $('.search-section').on('click', '.page-link', function (e) {
                e.preventDefault();
                var $link = $(this);
                if ($link.hasClass('active')) return;

                $link.closest('.pages').find('.page-link').removeClass('active');
                $link.addClass('active');

                getSearchSection($link.closest('.search-section'), parseInt($link.data('page')));
            });
        });
    </script>

@endsection
