{{-- Entry hero: square shape with selected color, animates to diamond on hover. Duplicate concept from square-diamond.blade.php. --}}
@php
    $bg_color = $bg_color ?? 'transparent';
@endphp
<style>
    .entry-hero-square-diamond-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    .entry-hero-square-diamond-inner {
        position: relative;
        width: 100%;
        height: 100%;
        aspect-ratio: 1;
        max-width: 100%;
        max-height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .entry-hero-square-diamond-shape {
        position: absolute;
        inset: 0;
        background: {!! $bg_color !!};
        transform-origin: 50% 50%;
        pointer-events: none;
    }
    .entry-hero-square-diamond-content {
        position: relative;
        z-index: 1;
        width: 100%;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        pointer-events: auto;
    }
</style>

<div class="entry-hero-square-diamond-wrapper">
    <div class="entry-hero-square-diamond-inner">
        <div class="entry-hero-square-diamond-shape"></div>
        <div class="entry-hero-square-diamond-content">
            {!! $content !!}
        </div>
    </div>
</div>

<script>
(function() {
    if (typeof gsap === 'undefined') {
        var s = document.createElement('script');
        s.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js';
        s.onload = initEntryHeroSquareDiamond;
        document.head.appendChild(s);
    } else {
        initEntryHeroSquareDiamond();
    }
    function initEntryHeroSquareDiamond() {
        document.querySelectorAll('.entry-hero-square-diamond-wrapper').forEach(function(wrapper) {
            var shape = wrapper.querySelector('.entry-hero-square-diamond-shape');
            var trigger = wrapper.querySelector('.entry-hero-diamond-trigger');
            if (!shape || !trigger) return;
            gsap.set(shape, { rotation: 0, scale: 1, transformOrigin: '50% 50%' });
            trigger.addEventListener('mouseenter', function() {
                gsap.to(shape, { rotation: 45, scale: 0.65, duration: 0.5, ease: 'power2.inOut', transformOrigin: '50% 50%' });
            });
            trigger.addEventListener('mouseleave', function() {
                gsap.to(shape, { rotation: 0, scale: 1, duration: 0.5, ease: 'power2.inOut', transformOrigin: '50% 50%' });
            });
        });
    }
})();
</script>
