<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    .donate-button-wrapper {
        display: inline-block;
        position: relative;
    }

    .donate-button-svg {
        display: block;
        cursor: pointer;
    }

    .donate-shape {
        transform-origin: 154px 154px;
    }

    .donate-text {
        pointer-events: none;
        user-select: none;
    }
</style>

<div class="container">
    <div class="donate-button-wrapper">
        <svg width="308" height="308" viewBox="0 0 308 308" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="donate-button-svg">
            <!-- Shape that morphs from square to circle -->
            <rect class="donate-shape" x="45.1065" y="45.1065" width="217.787" height="217.787" rx="0"
                fill="black" />
            <!-- Text inside -->
            <text class="donate-text" x="154" y="168" fill="white" font-family="Arial, sans-serif" font-size="24"
                font-weight="bold" text-anchor="middle">Donate</text>
        </svg>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const donateButton = document.querySelector('.donate-button-svg');
        const donateShape = document.querySelector('.donate-shape');

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
        }
    });
</script>
