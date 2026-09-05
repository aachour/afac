@php $uid = 'square-circle-' . uniqid(); @endphp
<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    .square-circle-donate-button-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 100%;
    }

    .square-circle-donate-button-svg {
        display: block;
        cursor: pointer;
    }

    #{{ $uid }} .square-circle-donate-text {
        fill:{{ $text_color }};
        color: {{ $text_color }};
    }
    .square-circle-donate-shape {
        transform-origin: 154px 154px;
    }
    #{{ $uid }}.square-circle-donate-button-svg:hover .square-circle-donate-text {
        fill: {{ $hover_text_color }};
        color: {{ $hover_text_color }};
    }

    #{{ $uid }}.square-circle-donate-button-svg:hover .square-circle-donate-shape {
        fill: {{ $hover_bg_color }};
    }

    .square-circle-donate-text {
        pointer-events: none;
        user-select: none;
    }

    @media (max-width: 768px) {
        .square-circle-donate-text-ar {
            top: 40% !important;
        }
    }
</style>

<div class="container">
    <div class="square-circle-donate-button-wrapper">
        <svg id="{{ $uid }}" width="250" height="250" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="square-circle-donate-button-svg">
            <!-- Shape that morphs from square to circle -->
            <rect class="square-circle-donate-shape" x="45.1065" y="45.1065" width="217.787" height="217.787" rx="0"
                fill="{{$bg_color}}" />
            <!-- Text inside -->
            @if(app()->getLocale() == 'en')
            <text class="square-circle-donate-text big ABCDiatypeMedium" x="154" y="160" text-anchor="middle">{{ trim($value) }}</text>
            @else
            {{-- foreignObject uses HTML rendering engine for proper Arabic letter shaping --}}
            <foreignObject x="0" y="0" width="308" height="308">
                <div xmlns="http://www.w3.org/1999/xhtml" style="position:relative;width:308px;height:308px;">
                    <div class="square-circle-donate-text square-circle-donate-text-ar big ABCDiatypeMedium"
                         style="position:absolute;top:50%;left:0;width:308px;transform:translateY(-50%);text-align:center;direction:rtl;pointer-events:none;user-select:none;">
                        {!! trim($value_arabic) !!}
                    </div>
                </div>
            </foreignObject>
            @endif
        </svg>
    </div>
</div>

<script>
(function () {
    function initSquareCircleButtons() {
        document.querySelectorAll('.square-circle-donate-button-wrapper').forEach(function (wrapper) {
            if (wrapper.dataset.squareCircleInitialized === 'true') return;

            const donateButton = wrapper.querySelector('.square-circle-donate-button-svg');
            const donateShape = wrapper.querySelector('.square-circle-donate-shape');
            if (!donateButton || !donateShape) return;

            wrapper.dataset.squareCircleInitialized = 'true';

            // Set initial state to square (rx="0", rotation="0")
            gsap.set(donateShape, {
                attr: {
                    rx: 0
                },
                rotation: 0,
                transformOrigin: "50% 50%"
            });

            donateButton.addEventListener('mouseenter', function() {
                // Transform from square to circle
                // Square: rx="0", rotation: 0
                // Circle: rx="108.8935", rotation: 0
                gsap.to(donateShape, {
                    attr: {
                        rx: 108.8935
                    },
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });

            donateButton.addEventListener('mouseleave', function() {
                // Transform back from circle to square
                gsap.to(donateShape, {
                    attr: {
                        rx: 0
                    },
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSquareCircleButtons);
    } else {
        initSquareCircleButtons();
    }
})();
</script>
