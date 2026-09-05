@php
    $trigger_selector = $trigger_selector ?? null;
    $use_trigger = !empty($trigger_selector);
    $uid = 'square-diamond-' . uniqid();
@endphp
<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    .square-diamond-donate-button-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 100%;
    }

    .square-diamond-donate-button-svg {
        display: block;
        cursor: pointer;
    }

    #{{ $uid }} .square-diamond-donate-text {
        fill:{{ $text_color }};
        color: {{ $text_color }};
    }

    .square-diamond-donate-shape {
        transform-origin: 154px 154px;
    }
    @if (!$use_trigger)
    #{{ $uid }}.square-diamond-donate-button-svg:hover .square-diamond-donate-text {
        fill: {{ $hover_text_color }};
        color: {{ $hover_text_color }};
    }
    #{{ $uid }}.square-diamond-donate-button-svg:hover .square-diamond-donate-shape {
        fill: {{ $hover_bg_color }};
    }
    @else
    #{{ $uid }}.trigger-active .square-diamond-donate-text {
        fill: {{ $hover_text_color }};
        color: {{ $hover_text_color }};
    }
    #{{ $uid }}.trigger-active .square-diamond-donate-shape {
        fill: {{ $hover_bg_color }};
    }
    #{{ $uid }} .square-diamond-donate-arrow {
        position: absolute;
        right: 24px;
        top: 50%;
        transform: translateY(-50%) translateX(-16px);
        opacity: 0;
        pointer-events: none;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
    #{{ $uid }} .square-diamond-donate-arrow svg {
        width: 26px;
        height: 24px;
        display: block;
    }
    #{{ $uid }}.trigger-active .square-diamond-donate-arrow {
        transform: translateY(-50%) translateX(0);
        opacity: 1;
        color: {{ $hover_text_color }};
    }
    @endif

    .square-diamond-donate-text {
        pointer-events: none;
        user-select: none;
    }

    @media (max-width: 768px) {
        .square-diamond-donate-text-ar {
            top: 40% !important;
        }
    }
</style>

<div class="container">
    <div id="{{ $uid }}" class="square-diamond-donate-button-wrapper" @if($use_trigger) data-trigger-selector="{{ $trigger_selector }}" @endif>
        <svg width="250" height="250" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="square-diamond-donate-button-svg">
            <!-- Shape that morphs from square to diamond -->
            <rect class="square-diamond-donate-shape" x="45.1065" y="45.1065" width="217.787" height="217.787" rx="0"
                fill="{{$bg_color}}" />
            <!-- Text inside -->
            @if(app()->getLocale() == 'en')
            <text class="square-diamond-donate-text big ABCDiatypeMedium" x="154" y="160" text-anchor="middle">{{ trim($value) }}</text>
            @else
            {{-- foreignObject uses HTML rendering engine for proper Arabic letter shaping --}}
            <foreignObject x="0" y="0" width="308" height="308">
                <div xmlns="http://www.w3.org/1999/xhtml" style="position:relative;width:308px;height:308px;">
                    <div class="square-diamond-donate-text square-diamond-donate-text-ar big ABCDiatypeMedium"
                         style="position:absolute;top:50%;left:0;width:308px;transform:translateY(-50%);text-align:center;direction:rtl;pointer-events:none;user-select:none;">
                        {!! trim($value_arabic) !!}
                    </div>
                </div>
            </foreignObject>
            @endif
        </svg>
        @if($use_trigger)
        <div class="square-diamond-donate-arrow" aria-hidden="true">
            <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.2128 23.5743L11.9388 21.3256L19.8348 13.4295H0V10.1448H19.8348L11.9388 2.26142L14.2128 0L26 11.7872L14.2128 23.5743Z" fill="currentColor"/></svg>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var wrappers = document.querySelectorAll('.square-diamond-donate-button-wrapper');
        wrappers.forEach(function(wrapper) {
            if (wrapper.dataset.squareDiamondInitialized === 'true') return;

            var donateButton = wrapper.querySelector('.square-diamond-donate-button-svg');
            var donateShape = wrapper.querySelector('.square-diamond-donate-shape');
            var triggerSelector = wrapper.getAttribute('data-trigger-selector');
            var useTrigger = triggerSelector && triggerSelector.length;

            if (!donateShape) return;

            wrapper.dataset.squareDiamondInitialized = 'true';

            gsap.set(donateShape, { attr: { rx: 0 }, rotation: 0, transformOrigin: "50% 50%" });

            function animateToDiamond() {
                gsap.to(donateShape, { rotation: -45, duration: 0.5, ease: "power2.inOut", transformOrigin: "50% 50%" });
                wrapper.classList.add('trigger-active');
            }
            function animateToSquare() {
                gsap.to(donateShape, { rotation: 0, duration: 0.5, ease: "power2.inOut", transformOrigin: "50% 50%" });
                wrapper.classList.remove('trigger-active');
            }

            if (useTrigger) {
                document.addEventListener('mouseover', function(e) {
                    if (e.target.closest(triggerSelector)) animateToDiamond();
                });
                document.addEventListener('mouseout', function(e) {
                    if (e.target.closest(triggerSelector) && (!e.relatedTarget || !e.relatedTarget.closest(triggerSelector)))
                        animateToSquare();
                });
            } else {
                donateButton.addEventListener('mouseenter', function() {
                    gsap.to(donateShape, { rotation: -45, duration: 0.5, ease: "power2.inOut", transformOrigin: "50% 50%" });
                });
                donateButton.addEventListener('mouseleave', function() {
                    gsap.to(donateShape, { rotation: 0, duration: 0.5, ease: "power2.inOut", transformOrigin: "50% 50%" });
                });
            }
        });
    });
</script>
