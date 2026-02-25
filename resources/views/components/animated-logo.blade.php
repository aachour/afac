<!-- GSAP Library -->
<script src="{{asset('frontend/js/gsap.js')}}"></script>

<div class="animated-logo-wrapper">
    <svg width="1200" height="600" viewBox="0 0 437 233" fill="none" xmlns="http://www.w3.org/2000/svg"
        class="animated-logo-svg">

        <g class="logo-container">

            <!-- Base logo shapes from official SVG -->
            <!-- Small connector near right vertical -->
            <path d="M381.88 163.82V165.48C381.88 165.2 381.9 164.93 381.9 164.65C381.9 164.37 381.88 164.1 381.88 163.82Z"
                fill="#010101" />

            <!-- Right Diamond (Rhombus) -->
            <g class="diamond-right">
                <path
                    d="M266.22 48.47L314.17 96.43L362.39 48.22L314.17 0L266.22 47.96L266.47 48.22L266.22 48.47Z"
                    fill="#010101" />
            </g>

            <!-- Left Diamond (Rhombus) -->
            <g class="diamond-left">
                <path d="M170.08 48.25L170.04 48.21L170.08 48.18L121.9 0L73.68 48.21L121.9 96.43L170.08 48.25Z"
                    fill="#010101" />
            </g>

            <!-- Middle Diamond (Rhombus) - This will rotate 45 degrees to become a square -->
            <g class="diamond-middle" id="middle-diamond" transform-origin="218.148 48.25">
                <path class="diamond-path"
                    d="M170.08 48.25L218.26 96.43L266.22 48.47L265.96 48.21L266.22 47.96L218.26 0L170.08 48.18L170.11 48.22L170.08 48.25Z"
                    fill="#010101" />
                <!-- Invisible hover zone for middle diamond -->
                <rect x="170" y="0" width="96" height="96" fill="transparent" class="hover-zone-middle"
                    style="cursor: pointer;" />
            </g>

            <!-- Tiny connector paths from official SVG -->
            <path d="M266.22 47.98L265.97 48.23L266.22 48.48L266.48 48.23L266.22 47.98Z" fill="#010101" />
            <path d="M170.08 48.25L170.11 48.22L170.08 48.18L170.04 48.21L170.08 48.25Z" fill="#010101" />

            <!-- Left vertical block -->
            <rect x="1.62" y="98.02" width="54.12" height="134.53" fill="#010101" />

            <!-- Left circle (O) -->
            <path
                d="M123.78 96.43C86.21 96.43 55.75 126.89 55.75 164.46C55.75 202.03 86.21 232.49 123.78 232.49C161.35 232.49 191.81 202.03 191.81 164.46C191.81 126.89 161.35 96.43 123.78 96.43ZM123.78 175.51C117.68 175.51 112.73 170.56 112.73 164.46C112.73 158.36 117.68 153.41 123.78 153.41C129.88 153.41 134.83 158.36 134.83 164.46C134.83 170.56 129.88 175.51 123.78 175.51Z"
                fill="#010101" />

            <!-- Left bottom bar -->
            <rect x="55.74" y="221.7" width="69.58" height="10.79" fill="#010101" />

            <!-- Middle vertical block -->
            <rect x="191.81" y="98.25" width="54.12" height="134.53" fill="#010101" />

            <!-- Right circle (O) -->
            <path
                d="M313.96 96.66C276.39 96.66 245.93 127.12 245.93 164.69C245.93 202.26 276.39 232.72 313.96 232.72C351.53 232.72 381.99 202.26 381.99 164.69C381.99 127.12 351.53 96.66 313.96 96.66ZM313.96 175.74C307.86 175.74 302.91 170.79 302.91 164.69C302.91 158.59 307.86 153.64 313.96 153.64C320.06 153.64 325.01 158.59 325.01 164.69C325.01 170.79 320.06 175.74 313.96 175.74Z"
                fill="#010101" />

            <!-- Right bottom bar -->
            <rect x="245.93" y="221.93" width="69.58" height="10.79" fill="#010101" />

            <!-- Right vertical block -->
            <rect x="381.99" y="96.56" width="54.12" height="134.53" fill="#010101" />

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
                
                <text x="1" y="104" fill="#010101" font-family="Arial, sans-serif" font-size="11" font-weight="bold">Based</text>
                <text x="1" y="118" fill="#010101" font-family="Arial, sans-serif" font-size="11" font-weight="bold">in Beirut</text>
            </g>

            <!-- Black cover that slides down to reveal animation-3 -->
            <rect id="animation-3-cover" x="1.5" y="95" width="54.2" height="60" fill="#010101" />
            
            <!-- Hover zone for bottom-left -->
            <rect x="0" y="80" width="90" height="145" fill="transparent" class="hover-zone-bottom-left"
                style="cursor: pointer;" />
        </g>
    </svg>
</div>

<style>
    .animated-logo-wrapper {
        display: inline-block;
        cursor: pointer;
        position: relative;
        will-change: transform;
    }

    .animated-logo-wrapper.logo-minimized {
        position: fixed;
        z-index: 9999;
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

        // Initialize animation2 with scale 0
        if (animation2) {
            gsap.set(animation2, {
                scale: 0,
                svgOrigin: "313.691 164.631"
            });
        }

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
                    ease: "power2.out",
                    svgOrigin: "313.691 164.631"
                });
            });

            hoverZoneCircle.addEventListener('mouseleave', function() {
                gsap.to(animation2, {
                    opacity: 0,
                    scale: 0,
                    duration: 0.3,
                    ease: "power2.in",
                    svgOrigin: "313.691 164.631"
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

        // Click animation: Zoom out to 150px and move to upper left corner
        const logoWrapper = document.querySelector('.animated-logo-wrapper');
        const logoSvg = document.querySelector('.animated-logo-svg');
        let isMinimized = false;

        if (logoWrapper && logoSvg) {
            logoWrapper.addEventListener('click', function(e) {
                // Prevent triggering hover animations when clicking
                e.stopPropagation();
                
                if (isMinimized) return; // Already minimized, prevent re-animation
                isMinimized = true;

                // Get current position and dimensions
                const rect = logoWrapper.getBoundingClientRect();
                const currentWidth = rect.width;
                const currentX = rect.left + (rect.width / 2); // Center X
                const currentY = rect.top + (rect.height / 2); // Center Y
                
                // Calculate scale to reach 150px width
                const targetWidth = 150;
                const scale = targetWidth / currentWidth;
                
                // Target position (upper left corner)
                const targetX = 20 + (targetWidth / 2); // Center of logo at 20px from left
                const targetY = 20 + ((rect.height * scale) / 2); // Center of logo at 20px from top

                // Set fixed positioning immediately to prevent layout shifts
                logoWrapper.classList.add('logo-minimized');
                gsap.set(logoWrapper, {
                    left: currentX - (rect.width / 2),
                    top: currentY - (rect.height / 2),
                    x: 0,
                    y: 0,
                    scale: 1
                });

                // Create timeline for smooth animation
                const tl = gsap.timeline();

                // Animate both scale and position simultaneously
                tl.to(logoWrapper, {
                    scale: scale,
                    x: targetX - currentX,
                    y: targetY - currentY,
                    duration: 0.8,
                    ease: "power2.inOut",
                    transformOrigin: "center center",
                    onComplete: function() {
                        // Set final position and dimensions
                        const finalHeight = rect.height * scale;
                        gsap.set(logoWrapper, {
                            left: 20,
                            top: 20,
                            clearProps: "x,y,scale"
                        });
                        gsap.set(logoSvg, {
                            width: targetWidth,
                            height: "auto"
                        });
                    }
                });
            });
        }
    });
</script>
