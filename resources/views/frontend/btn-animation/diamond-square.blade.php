@php $uid = 'diamond-square-' . uniqid(); @endphp
<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    .diamond-square-donate-button-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 100%;
    }

    .diamond-square-donate-button-svg {
        display: block;
        cursor: pointer;
    }

    #{{ $uid }} .diamond-square-donate-text {
        fill:{{ $text_color }};
        color: {{ $text_color }};
    }
    .diamond-square-donate-shape {
        transform-origin: 154px 154px;
    }
    #{{ $uid }}.diamond-square-donate-button-svg:hover .diamond-square-donate-text {
        fill: {{ $hover_text_color }};
        color: {{ $hover_text_color }};
    }

    #{{ $uid }}.diamond-square-donate-button-svg:hover .diamond-square-donate-shape {
        fill: {{ $hover_bg_color }};
    }

    .diamond-square-donate-text {
        pointer-events: none;
        user-select: none;
    }

    @media (max-width: 768px) {
        .diamond-square-donate-text-ar {
            top: 40% !important;
        }
    }
</style>

<div class="container">
    <div class="diamond-square-donate-button-wrapper">
        <svg id="{{ $uid }}" width="250" height="250" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="diamond-square-donate-button-svg">
            <!-- Shape that morphs from diamond to square -->
            <rect class="diamond-square-donate-shape" x="45.1065" y="45.1065" width="217.787" height="217.787" rx="0"
                fill="{{$bg_color}}" />
            <!-- Text inside -->
            @if(app()->getLocale() == 'en')
            <text class="diamond-square-donate-text big ABCDiatypeMedium" x="154" y="160" text-anchor="middle">{{ trim($value) }}</text>
            @else
            {{-- foreignObject uses HTML rendering engine for proper Arabic letter shaping --}}
            <foreignObject x="0" y="0" width="308" height="308">
                <div xmlns="http://www.w3.org/1999/xhtml" style="position:relative;width:308px;height:308px;">
                    <div class="diamond-square-donate-text diamond-square-donate-text-ar big ABCDiatypeMedium"
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
    function initDiamondSquareButtons() {
        document.querySelectorAll('.diamond-square-donate-button-wrapper').forEach(function (wrapper) {
            if (wrapper.dataset.diamondSquareInitialized === 'true') return;

            const donateButton = wrapper.querySelector('.diamond-square-donate-button-svg');
            const donateShape = wrapper.querySelector('.diamond-square-donate-shape');
            if (!donateButton || !donateShape) return;

            wrapper.dataset.diamondSquareInitialized = 'true';

            // Set initial state to diamond (rx="0", rotation="-45")
            gsap.set(donateShape, {
                attr: {
                    rx: 0
                },
                rotation: -45,
                transformOrigin: "50% 50%"
            });

            donateButton.addEventListener('mouseenter', function() {
                // Transform from diamond to square
                // Diamond: rx="0", rotation: -45
                // Square: rx="0", rotation: 0 (no rotation needed)
                gsap.to(donateShape, {
                    rotation: 0,
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });

            donateButton.addEventListener('mouseleave', function() {
                // Transform back from square to diamond
                gsap.to(donateShape, {
                    rotation: -45,
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDiamondSquareButtons);
    } else {
        initDiamondSquareButtons();
    }
})();
</script>
