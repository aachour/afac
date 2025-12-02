<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    .circle-square-donate-button-wrapper {
        display: inline-block;
        position: relative;
    }

    .circle-square-donate-button-svg {
        display: block;
        cursor: pointer;
    }

    .circle-square-donate-shape {
        transform-origin: 154px 154px;
    }

    .circle-square-donate-text {
        pointer-events: none;
        user-select: none;
    }
</style>

<div class="container">
    <div class="circle-square-donate-button-wrapper">
        <svg width="308" height="308" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg" class="circle-square-donate-button-svg">
            <!-- Shape that morphs from circle to square -->
            <rect class="circle-square-donate-shape" x="45.1065" y="45.1065" width="217.787" height="217.787" rx="108.8935" fill="black"/>
            <!-- Text inside -->
            <text class="circle-square-donate-text" x="154" y="168" fill="white" font-family="Arial, sans-serif" font-size="24" font-weight="bold" text-anchor="middle">Donate</text>
        </svg>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.circle-square-donate-button-wrapper');
    if (!wrapper) return;
    
    const donateButton = wrapper.querySelector('.circle-square-donate-button-svg');
    const donateShape = wrapper.querySelector('.circle-square-donate-shape');
    
    if (donateButton && donateShape) {
        // Center of the SVG (308 / 2 = 154)
        const centerX = 154;
        const centerY = 154;
        
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
    }
});
</script>
