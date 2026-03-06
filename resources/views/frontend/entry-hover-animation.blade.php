@php
    $text = $button_text ?? 'Press Here';
    $size = $size ?? 'medium';
    $button_bg_color = $button_bg_color ?? '#E3F2FD';
    $textColor = $textColor ?? '#010101';
@endphp


@php
    $sizes = [
        'small' => [
            'diamond' => 160,
            'fontSize' => 18,
            'lineHeight' => 20,
            'padding' => 12,
        ],
        'medium' => [
            'diamond' => 200,
            'fontSize' => 20,
            'lineHeight' => 22,
            'padding' => 16,
        ],
        'large' => [
            'diamond' => 240,
            'fontSize' => 24,
            'lineHeight' => 26,
            'padding' => 20,
        ],
    ];

    $config = $sizes[$size] ?? $sizes['medium'];
    $diamondSize = $config['diamond'];
    $center = $diamondSize / 2;
    $textLines = explode(' ', $text);
    $line1 = $textLines[0] ?? '';
    $line2 = implode(' ', array_slice($textLines, 1)) ?? '';
@endphp

<!-- GSAP Library -->
<script src="{{ asset('frontend/js/gsap.js') }}"></script>

<style>    

    .card-hover-animation-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
        height: 100%;
    }

    .card-hover-animation-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        z-index: 100;
        opacity: 0;
    }

    .card-hover-animation-diamond {
        transform-origin: center center;
    }

    .card-hover-animation-text {
        pointer-events: none;
        user-select: none;
    }
</style>

<div class="card-hover-animation-wrapper entry_card clickable" event_category_name="{{ @$event_category_name }}"
    event_start_date="{{ @$event_start_date }}" event_end_date="{{ @$event_end_date }}"
    program_start_date="{{ @$program_start_date }}" program_end_date="{{ @$program_end_date }}"
    project_categories="{{ @$project_categories }}" project_countries="{{ @$project_countries }}"
    grantee_categories="{{ @$grantee_categories }}" grantee_country="{{ @$grantee_country }}"
    jury_country_id="{{ @$jury_country_id }}" resource_category_name="{{ @$resource_category_name }}"
    resource_date="{{ @$resource_date }}" news_date="{{ @$news_date }}" featured="{{ @$featured }}"
    data-hover-animation entry_title="{{@$entry_title}}" entry_position="{{@$entry_position}}" entry_text="{{@$entry_text}}" entry_href="{{@$entry_href}}">

    @if ($featured == 1)
        <img src="{{ $image_path }}" width="100%" />
    @else
        @if ($collection_type_id != 9 && $collection_type_id != 10)
            <a href="{{ $entry_href }}" target="{{ $entry_target }}">
        @endif

        <img src="{{ $image_path }}" width="100%" />
        <div class="description">
            <div class="title_or_labels medium white ABCDiatypeMedium"
                style="{{ $title_position }} padding-right:5px;">
                {{ $entry_title }}
                @if(!empty($entry_position))
                    <div class="mt-2 tiny">{!!$entry_position!!}</div>
                @endif
            </div>

            @if ($with_label == 1)
                <div class="title_or_labels" style="{{ $labels_position }}">
                    <!-- <div class="label micro black ABCDiatypeMedium">{{ $entry_type_name }}</div> -->
                    @if ($collection_type_id == 1)
                        @if (@$labels[0] != '')
                        <div class="label micro black ABCDiatypeMedium">{{ @$labels[0] }}</div>
                        @endif
                        @if (@$labels[1] != '')
                        <div class="label micro black rounded ABCDiatypeMedium">{{ @$labels[1] }}</div>
                        @endif
                        @if (@$labels[2] != '')
                            <div class="label micro black rounded ABCDiatypeMedium">
                                {{ $labels[2] ?? '' }}
                            </div>
                        @endif
                        @if (@$labels[3] != '')
                            <div class="label micro black rounded ABCDiatypeMedium">
                                {{ $labels[3] ?? '' }}{{ isset($labels[4]) ? ' - ' . $labels[4] : '' }}
                            </div>
                        @endif
                    @else
                        @foreach ($labels as $key=>$label)
                            <div class="label micro black ABCDiatypeMedium {{ $key != 0 ? 'rounded' : '' }}">{{ $label }}</div>
                        @endforeach
                    @endif
                    <div class="clear">&nbsp;</div>
                </div>
            @endif
        </div>

        @if ($collection_type_id != 9 && $collection_type_id != 10)
            </a>
        @endif

    @endif

    <svg class="card-hover-animation-overlay" width="{{ $diamondSize }}" height="{{ $diamondSize }}"
        viewBox="0 0 {{ $diamondSize }} {{ $diamondSize }}" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Diamond shape - rotated square -->
        <g transform="translate({{ $center }}, {{ $center }}) rotate(-45)">
            <rect class="card-hover-animation-diamond" x="{{ -$diamondSize * 0.3535 }}"
                y="{{ -$diamondSize * 0.3535 }}" width="{{ $diamondSize * 0.707 }}"
                height="{{ $diamondSize * 0.707 }}" rx="4" fill="{{ $button_bg_color }}" />
        </g>

        <!-- Text inside diamond - not rotated, centered -->
        <text class="card-hover-animation-text" x="{{ $center }}"
            y="{{ $center - $config['lineHeight'] * 0.4 }}" fill="{{ $textColor }}"
            font-family="Arial, sans-serif" font-size="{{ $config['fontSize'] }}" font-weight="bold"
            text-anchor="middle" dominant-baseline="central">
            {{ $line1 }}
        </text>
        @if ($line2)
            <text class="card-hover-animation-text" x="{{ $center }}"
                y="{{ $center + $config['lineHeight'] * 0.6 }}" fill="{{ $textColor }}"
                font-family="Arial, sans-serif" font-size="{{ $config['fontSize'] }}" font-weight="bold"
                text-anchor="middle" dominant-baseline="central">
                {{ $line2 }}
            </text>
        @endif
    </svg>


</div>

<script>
    function initHoverAnimations() {
        const wrappers = document.querySelectorAll('[data-hover-animation]');

        wrappers.forEach(function(wrapper) {
            if (wrapper.dataset.hoverInitialized) return;

            const overlay = wrapper.querySelector('.card-hover-animation-overlay');
            if (!overlay) return;

            gsap.set(overlay, {
                opacity: 0,
                scale: 0.8
            });

            wrapper.addEventListener('mouseenter', function() {
                gsap.killTweensOf(overlay);
                gsap.to(overlay, {
                    opacity: 1,
                    scale: 1,
                    duration: 0.65,
                    ease: "power2.out"
                });
            });

            wrapper.addEventListener('mouseleave', function() {
                gsap.killTweensOf(overlay);
                gsap.to(overlay, {
                    opacity: 0,
                    scale: 0.8,
                    duration: 0.4,
                    ease: "power2.in"
                });
            });

            wrapper.dataset.hoverInitialized = true;
        });
    }

    // Run on page load
    document.addEventListener('DOMContentLoaded', initHoverAnimations);

    // Run again after AJAX success
    // example:
    $(document).ajaxComplete(function() {
        initHoverAnimations();
    });



    $(document).on("click", ".card-hover-animation-wrapper", function () {

        var entry_href=$(this).attr("entry_href"); 
        var entry_title=$(this).attr("entry_title");
        var entry_position=$(this).attr("entry_position");
        var entry_text=$(this).attr("entry_text");
        if($.trim(entry_href)==''){
            $(".popupEntry").find("#title").text(entry_title);
            $(".popupEntry").find("#position").html(entry_position);
            $(".popupEntry").find("#text").html(entry_text);
            $(".popupEntry").removeClass("d-none");
        }
        
    });

    $(document).on("click", ".closeBtn", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(".popupEntry").addClass("d-none");
    });
</script>
