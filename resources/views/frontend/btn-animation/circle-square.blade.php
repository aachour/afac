@php $uid = 'circle-square-' . uniqid(); @endphp
<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    .circle-square-donate-button-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 100%;
    }

    .circle-square-donate-button-svg {
        display: block;
        cursor: pointer;
    }

    #{{ $uid }} .circle-square-donate-text {
        fill:{{ $text_color }};
    }

    .circle-square-donate-shape {
        transform-origin: 154px 154px;
    }
    #{{ $uid }}.circle-square-donate-button-svg:hover .circle-square-donate-text {
        fill: {{ $hover_text_color }};
    }

    #{{ $uid }}.circle-square-donate-button-svg:hover .circle-square-donate-shape {
        fill: {{ $hover_bg_color }};
    }

    .circle-square-donate-text {
        pointer-events: none;
        user-select: none;
    }
</style>

<div class="container">
    <div class="circle-square-donate-button-wrapper">
        <svg id="{{ $uid }}" width="250" height="250" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg" class="circle-square-donate-button-svg">
            <!-- Shape that morphs from circle to square -->
            <rect class="circle-square-donate-shape" x="45.1065" y="45.1065" width="217.787" height="217.787" rx="108.8935" fill="{{$bg_color}}"/>
            <!-- Text inside -->
            <text class="circle-square-donate-text big ABCDiatypeMedium" x="154" y="168"  text-anchor="middle">{{ app()->getLocale() == 'en' ? $value : $value_arabic }}</text>
        </svg>
    </div>
</div>

<script>
(function () {
    function initCircleSquareButtons() {
        document.querySelectorAll('.circle-square-donate-button-wrapper').forEach(function (wrapper) {
            if (wrapper.dataset.circleSquareInitialized === 'true') return;

            const donateButton = wrapper.querySelector('.circle-square-donate-button-svg');
            const donateShape = wrapper.querySelector('.circle-square-donate-shape');
            if (!donateButton || !donateShape) return;

            wrapper.dataset.circleSquareInitialized = 'true';

            donateButton.addEventListener('mouseenter', function() {
                // Transform from circle to square
                // Circle: rx="108.8935", rotation: 0
                // Square: rx="0", rotation: 0 (no rotation needed)
                gsap.to(donateShape, {
                    attr: { rx: 0 },
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });

            donateButton.addEventListener('mouseleave', function() {
                // Transform back from square to circle
                gsap.to(donateShape, {
                    attr: { rx: 108.8935 },
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCircleSquareButtons);
    } else {
        initCircleSquareButtons();
    }
})();
</script>
