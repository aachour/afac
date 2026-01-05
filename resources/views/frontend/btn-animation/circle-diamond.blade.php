<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    .circle-diamond-donate-button-wrapper {
        display: inline-block;
        position: relative;
    }

    .circle-diamond-donate-button-svg {
        display: block;
        cursor: pointer;
    }

    .circle-diamond-donate-text {
        fill:{{ $text_color }};
    }
    .circle-diamond-donate-shape {
        transform-origin: 154px 154px;
    }
    .circle-diamond-donate-button-svg:hover .circle-diamond-donate-text {
        fill: {{ $hover_text_color }};
    }

    .circle-diamond-donate-button-svg:hover .circle-diamond-donate-shape {
        fill: {{ $hover_bg_color }};
    }

    .circle-diamond-donate-text {
        pointer-events: none;
        user-select: none;
    }
</style>

<div class="container">
    <div class="circle-diamond-donate-button-wrapper">
        <svg width="308" height="308" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg" class="circle-diamond-donate-button-svg">
            <!-- Shape that morphs from circle to diamond -->
            <rect class="circle-diamond-donate-shape" x="45.1065" y="45.1065" width="217.787" height="217.787" rx="108.8935" fill="{{$bg_color}}" />
            <!-- Text inside -->
            <text class="circle-diamond-donate-text medium ABCDiatypeMedium" x="154" y="168" text-anchor="middle">{{ $value }}</text>
        </svg>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.circle-diamond-donate-button-wrapper');
    if (!wrapper) return;
    
    const donateButton = wrapper.querySelector('.circle-diamond-donate-button-svg');
    const donateShape = wrapper.querySelector('.circle-diamond-donate-shape');
    
    if (donateButton && donateShape) {
        // Center of the SVG (308 / 2 = 154)
        const centerX = 154;
        const centerY = 154;
        
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
    }
});
</script>
