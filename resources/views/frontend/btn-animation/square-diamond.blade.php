<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    .square-diamond-donate-button-wrapper {
        display: inline-block;
        position: relative;
    }

    .square-diamond-donate-button-svg {
        display: block;
        cursor: pointer;
    }

    .square-diamond-donate-text {
        fill:{{ $text_color }};
    }

    .square-diamond-donate-shape {
        transform-origin: 154px 154px;
    }
    .square-diamond-donate-button-svg:hover .square-diamond-donate-text {
        fill: {{ $hover_text_color }};
    }

    .square-diamond-donate-button-svg:hover .square-diamond-donate-shape {
        fill: {{ $hover_bg_color }};
    }

    .square-diamond-donate-text {
        pointer-events: none;
        user-select: none;
    }
</style>

<div class="container">
    <div class="square-diamond-donate-button-wrapper">
        <svg width="308" height="308" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="square-diamond-donate-button-svg">
            <!-- Shape that morphs from square to diamond -->
            <rect class="square-diamond-donate-shape" x="45.1065" y="45.1065" width="217.787" height="217.787" rx="0"
                fill="{{$bg_color}}" />
            <!-- Text inside -->
            <text class="square-diamond-donate-text medium ABCDiatypeMedium" x="154" y="168" text-anchor="middle">{{ $value }}</text>
        </svg>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.querySelector('.square-diamond-donate-button-wrapper');
        if (!wrapper) return;
        
        const donateButton = wrapper.querySelector('.square-diamond-donate-button-svg');
        const donateShape = wrapper.querySelector('.square-diamond-donate-shape');

        if (donateButton && donateShape) {
            // Center of the SVG (308 / 2 = 154)
            const centerX = 154;
            const centerY = 154;

            // Set initial state to square (rx="0", rotation="0")
            gsap.set(donateShape, {
                attr: {
                    rx: 0
                },
                rotation: 0,
                transformOrigin: "50% 50%"
            });

            donateButton.addEventListener('mouseenter', function() {
                // Transform from square to diamond
                // Square: rx="0", rotation: 0
                // Diamond: rx="0", rotation: -45
                gsap.to(donateShape, {
                    rotation: -45,
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });

            donateButton.addEventListener('mouseleave', function() {
                // Transform back from diamond to square
                gsap.to(donateShape, {
                    rotation: 0,
                    duration: 0.5,
                    ease: "power2.inOut",
                    transformOrigin: "50% 50%"
                });
            });
        }
    });
</script>
