<!-- GSAP Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<div class="animated-logo-wrapper">
    <svg width="1200" height="600" viewBox="0 0 437 233" fill="none" xmlns="http://www.w3.org/2000/svg"
        class="animated-logo-svg">
        <g class="logo-container">
            <!-- Left L shape -->
            <path
                d="M381.899 164.649C381.899 164.929 381.879 165.199 381.879 165.479V232.819H436.439V96.4492H381.879V163.829C381.879 164.109 381.899 164.379 381.899 164.659V164.649Z"
                fill="#010101" />
            <path
                d="M381.881 163.821C381.431 126.551 351.091 96.4614 313.721 96.4614L313.701 96.4414C276.031 96.4414 245.511 126.981 245.511 164.631C245.511 191.631 261.201 214.951 283.951 226.011H245.511V96.4514H190.961V232.841H313.711C351.101 232.841 381.431 202.751 381.871 165.481V163.821H381.881ZM313.691 174.861C308.041 174.861 303.471 170.291 303.471 164.631C303.471 158.971 308.041 154.401 313.691 154.401C319.341 154.401 323.921 158.971 323.921 164.631C323.921 170.291 319.351 174.861 313.691 174.861Z"
                fill="#010101" />
            <path
                d="M381.879 163.82V165.48C381.879 165.2 381.899 164.93 381.899 164.65C381.899 164.37 381.879 164.1 381.879 163.82Z"
                fill="#010101" />
            <path
                d="M190.94 164.651C190.94 127.001 160.4 96.4614 122.75 96.4614V96.4414C85.1 96.4414 54.56 126.981 54.56 164.631C54.56 191.631 70.25 214.951 93 226.011H54.56V96.4514H0V232.841H122.75C160.4 232.841 190.94 202.301 190.94 164.651ZM112.53 164.631C112.53 158.981 117.1 154.401 122.76 154.401C128.42 154.401 132.99 158.971 132.99 164.631C132.99 170.291 128.42 174.861 122.76 174.861C117.1 174.861 112.53 170.291 112.53 164.631Z"
                fill="#010101" />

            <!-- Left Diamond (Rhombus) -->
            <g class="diamond-left">
                <path d="M170.08 48.25L170.04 48.21L170.08 48.18L121.9 0L73.6797 48.21L121.9 96.43L170.08 48.25Z"
                    fill="#010101" />
            </g>

            <!-- Middle Diamond (Rhombus) - This will rotate 45 degrees to become a square -->
            <g class="diamond-middle" id="middle-diamond" transform-origin="218.148 48.25">
                <path class="diamond-path"
                    d="M170.078 48.25L218.258 96.43L266.218 48.47L265.958 48.21L266.218 47.96L218.258 0L170.078 48.18L170.108 48.22L170.078 48.25Z"
                    fill="#010101" />
                <!-- Invisible hover zone for middle diamond -->
                <rect x="170" y="0" width="96" height="96" fill="transparent" class="hover-zone-middle"
                    style="cursor: pointer;" />
            </g>

            <!-- Right Diamond (Rhombus) -->
            <g class="diamond-right">
                <path
                    d="M266.219 48.47L314.169 96.43L362.389 48.22L314.169 0L266.219 47.96L266.469 48.22L266.219 48.47Z"
                    fill="#010101" />
            </g>

            <path d="M266.223 47.9759L265.969 48.2305L266.223 48.485L266.478 48.2304L266.223 47.9759Z" fill="#010101" />
            <path d="M170.079 48.2497L170.109 48.2197L170.079 48.1797L170.039 48.2097L170.079 48.2497Z"
                fill="#010101" />

            <!-- Animation 1: Text that appears over the rotated middle diamond -->
            <g id="animation-1" class="animation-content" style="opacity: 0; pointer-events: none;">
                <text x="218.148" y="40" fill="#FFFFFF" font-family="Arial, sans-serif" font-size="11"
                    font-weight="bold" text-anchor="middle">Established</text>
                <text x="218.148" y="57" fill="#FFFFFF" font-family="Arial, sans-serif" font-size="11"
                    font-weight="bold" text-anchor="middle">in 2007</text>
            </g>

            <!-- Animation 2: Circle text (rightmost O circle) -->
            <!-- The rightmost O circle is created by the path at line 26, center around 313.691, 164.631 -->
            <g id="animation-2" class="animation-content" style="opacity: 0; pointer-events: none;">
                <!-- Yellow outline circle -->
                <circle cx="313.691" cy="164.631" r="40" fill="none" stroke="#010101" stroke-width="3" />
                <!-- White background circle -->
                <circle cx="313.691" cy="164.631" r="55" fill="#FFFFFF" />
                <text x="313.691" y="155" fill="#010101" font-family="Arial, sans-serif" font-size="9"
                    font-weight="bold" text-anchor="middle">Supporting</text>
                <text x="313.691" y="170" fill="#010101" font-family="Arial, sans-serif" font-size="9"
                    font-weight="bold" text-anchor="middle">2,000 initiatives</text>
                <text x="313.691" y="185" fill="#010101" font-family="Arial, sans-serif" font-size="9"
                    font-weight="bold" text-anchor="middle">and counting</text>
            </g>
            <!-- Hover zone for rightmost circle - matches the circle area -->
            <circle cx="313.691" cy="164.631" r="60" fill="transparent" class="hover-zone-circle"
                style="cursor: pointer;" />

            <!-- Animation 3: Based in Beirut (bottom-left) -->
            <g id="animation-3" class="animation-content" style="pointer-events: none;">
                <rect x="0" y="85" width="55" height="55" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2"
                    rx="2" />
                <text x="0" y="105" fill="#010101" font-family="Arial, sans-serif" font-size="11"
                    font-weight="bold">Based</text>
                <text x="0" y="125" fill="#010101" font-family="Arial, sans-serif" font-size="11" font-weight="bold">in
                    Beirut</text>
            </g>
            <!-- Black cover that slides down to reveal animation-3 -->
            <rect id="animation-3-cover" x="0" y="95" width="54.5" height="60" fill="#010101" />
            <!-- Hover zone for bottom-left -->
            <rect x="0" y="80" width="90" height="145" fill="transparent" class="hover-zone-bottom-left"
                style="cursor: pointer;" />
        </g>
    </svg>
</div>

<style>
    .animated-logo-wrapper {
        display: inline-block;
    }

    .animated-logo-svg {
        display: block;
        max-width: 100%;
        height: auto;
    }

    .animation-content {
        transition: opacity 0.3s ease;
    }

    .diamond-path {
        transform-origin: 218.148px 48.25px;
    }

    .diamond-middle {
        transform-origin: 218.148px 48.25px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const middleDiamondGroup = document.querySelector('.diamond-middle');
        const hoverZoneMiddle = document.querySelector('.hover-zone-middle');

        const hoverZoneCircle = document.querySelector('.hover-zone-circle');
        const animation2 = document.getElementById('animation-2');

        const hoverZoneBottomLeft = document.querySelector('.hover-zone-bottom-left');
        const animation3 = document.getElementById('animation-3');
        const animation3Cover = document.getElementById('animation-3-cover');

        // Animation 1: Rotate middle diamond 45 degrees on hover and show text
        const animation1 = document.getElementById('animation-1');
        if (hoverZoneMiddle && middleDiamondGroup) {
            const diamondPath = middleDiamondGroup.querySelector('.diamond-path');

            hoverZoneMiddle.addEventListener('mouseenter', function() {
                // Rotate the diamond path 45 degrees around its center
                gsap.to(diamondPath, {
                    rotation: -45,
                    duration: 0.7,
                    transformOrigin: "50% 50%"
                });

                // Show text with transparent background
                if (animation1) {
                    gsap.to(animation1, {
                        opacity: 1,
                        duration: 0.3,
                        delay: 0.2
                    });
                }
            });

            hoverZoneMiddle.addEventListener('mouseleave', function() {
                // Hide text
                if (animation1) {
                    gsap.to(animation1, {
                        opacity: 0,
                        duration: 0.3
                    });
                }

                // Rotate diamond back to original position
                gsap.to(diamondPath, {
                    rotation: 0,
                    duration: 0.7,
                    transformOrigin: "50% 50%"
                });
            });
        }

        // Animation 2: Circle text
        if (hoverZoneCircle && animation2) {
            hoverZoneCircle.addEventListener('mouseenter', function() {
                gsap.to(animation2, {
                    opacity: 1,
                    scale: 1,
                    duration: 0.2,
                    ease: "back.in(0.1)"
                });
            });

            hoverZoneCircle.addEventListener('mouseleave', function() {
                gsap.to(animation2, {
                    opacity: 0,
                    scale: 1,
                    duration: 0.1,
                    ease: "back.out(0.1)"
                });
            });
        }

        // Animation 3: Bottom-left text - black section slides down to reveal text
        if (hoverZoneBottomLeft && animation3 && animation3Cover) {
            hoverZoneBottomLeft.addEventListener('mouseenter', function() {
                // Slide the black cover down to reveal the text
                gsap.to(animation3Cover, {
                    y: 60,
                    duration: 0.7,
                    ease: "power2.out"
                });
            });

            hoverZoneBottomLeft.addEventListener('mouseleave', function() {
                // Slide the black cover back up to cover the text
                gsap.to(animation3Cover, {
                    y: 0,
                    duration: 0.7,
                    ease: "power2.in"
                });
            });
        }
    });
</script>
