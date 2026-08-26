@php $uid = 'circle-diamond-' . uniqid(); @endphp
<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    .circle-diamond-donate-button-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 100%;
    }

    .circle-diamond-donate-button-svg {
        display: block;
        cursor: pointer;
    }

    #{{ $uid }} .circle-diamond-donate-text {
        fill: {{ $text_color }};
        color: {{ $text_color }};
    }
    .circle-diamond-donate-shape {
        transform-origin: 154px 154px;
    }
    #{{ $uid }}.circle-diamond-donate-button-svg:hover .circle-diamond-donate-text {
        fill: {{ $hover_text_color }};
        color: {{ $hover_text_color }};
    }

    #{{ $uid }}.circle-diamond-donate-button-svg:hover .circle-diamond-donate-shape {
        fill: {{ $hover_bg_color }};
    }

    .circle-diamond-donate-text {
        pointer-events: none;
        user-select: none;
    }


</style>

<div class="container">
    <div class="circle-diamond-donate-button-wrapper">
        <svg id="{{ $uid }}" width="250" height="250" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg" class="circle-diamond-donate-button-svg">
            <!-- Shape that morphs from circle to diamond -->
            <rect class="circle-diamond-donate-shape" x="45.1065" y="45.1065" width="217.787" height="217.787" rx="108.8935" fill="{{$bg_color}}" />
            @if(app()->getLocale() == 'en')
            <text class="circle-diamond-donate-text big ABCDiatypeMedium"
                  x="154" y="168"
                  text-anchor="middle"
                  dominant-baseline="middle">
                {!! trim($value) !!}
            </text>
            @else
            {{-- foreignObject uses HTML rendering engine for proper Arabic letter shaping --}}
            <foreignObject x="0" y="0" width="308" height="308">
                {{-- outer div with explicit px dimensions establishes a containing block for iOS Safari --}}
                <div xmlns="http://www.w3.org/1999/xhtml"
                     style="position:relative;width:308px;height:308px;">
                    <div class="circle-diamond-donate-text big ABCDiatypeMedium"
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
    function initCircleDiamondButtons() {
        const wrappers = document.querySelectorAll('.circle-diamond-donate-button-wrapper');
        if (!wrappers.length) return;

        wrappers.forEach(function (wrapper) {
            if (wrapper.dataset.circleDiamondInitialized === 'true') return;

            const donateButton = wrapper.querySelector('.circle-diamond-donate-button-svg');
            const donateShape = wrapper.querySelector('.circle-diamond-donate-shape');
            if (!donateButton || !donateShape) return;

            wrapper.dataset.circleDiamondInitialized = 'true';

            donateButton.addEventListener('mouseenter', function() {
                // Transform from circle to diamond
                // Circle: rx="108.8935", rotation: 0
                // Diamond: rx="0", rotation: -45
                gsap.to(donateShape, {
                    attr: { rx: 0 },
                    rotation: -45,
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });

            donateButton.addEventListener('mouseleave', function() {
                // Transform back from diamond to circle
                gsap.to(donateShape, {
                    attr: { rx: 108.8935 },
                    rotation: 0,
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCircleDiamondButtons);
    } else {
        initCircleDiamondButtons();
    }
})();
</script>
