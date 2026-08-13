{{-- Entry hero: square shape with selected color, animates to diamond on hover. CTA trigger (Register Now) or grantee trigger. --}}
@php
    $bg_color = $bg_color ?? 'transparent';
    $trigger_selector = $trigger_selector ?? null;
    $use_grantee_trigger = !empty($trigger_selector);
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
        overflow: hidden;
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
    .entry-hero-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        color: inherit;
    }
    .entry-hero-cta-arrow-wrap {
        display: inline-block;
        width: 0;
        overflow: hidden;
        transition: width 0.3s ease;
        vertical-align: middle;
    }
    .entry-hero-diamond-trigger:hover .entry-hero-cta-arrow-wrap {
        width: 40px;
    }
    .entry-hero-cta-arrow {
        display: inline-block;
        width: 26px;
        height: 24px;
        transform: translateX(-26px);
        transition: transform 0.3s ease;
        vertical-align: middle;
    }
    .entry-hero-diamond-trigger:hover .entry-hero-cta-arrow {
        transform: translateX(6px);
    }
    @if($use_grantee_trigger)
    .entry-hero-grantee-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        color: inherit;
    }
    .entry-hero-grantee-arrow-wrap {
        display: inline-block;
        width: 0;
        overflow: hidden;
        transition: width 0.3s ease;
        vertical-align: middle;
    }
    .entry-hero-grantee-link:hover .entry-hero-grantee-arrow-wrap {
        width: 35px;
    }
    .entry-hero-grantee-link .entry-hero-grantee-arrow {
        display: inline-block;
        width: 26px;
        height: 24px;
        transform: translateX(-26px);
        transition: transform 0.3s ease;
        color: inherit;
        vertical-align: middle;
    }
    .entry-hero-grantee-link:hover .entry-hero-grantee-arrow {
        transform: translateX(4px);
    }
    @media (max-width: 768px) {
        .entry-hero-grantee-link .entry-hero-grantee-arrow {
            display: inline-block;
            width: 13px;
            height: 12px;
            transform: translateX(-26px);
            transition: transform 0.3s ease;
            color: inherit;
            vertical-align: middle;
        }
        .entry-hero-grantee-arrow-wrap {
            width: 35px !important;
            overflow: visible;
        }
        .entry-hero-grantee-arrow {
            transform: translateX(4px) !important;
        }
    }
    @endif
</style>

<div class="entry-hero-square-diamond-wrapper" @if($use_grantee_trigger) data-trigger-selector="{{ $trigger_selector }}" @endif>
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
            var triggerSelector = wrapper.getAttribute('data-trigger-selector');
            var useGranteeTrigger = triggerSelector && triggerSelector.length;

            if (!shape) return;
            gsap.set(shape, { rotation: 0, scale: 1, transformOrigin: '50% 50%' });

            function toDiamond() {
                gsap.to(shape, { rotation: 45, scale: 0.65, duration: 0.5, ease: 'power2.inOut', transformOrigin: '50% 50%' });
                wrapper.classList.add('trigger-active');
            }
            function toSquare() {
                gsap.to(shape, { rotation: 0, scale: 1, duration: 0.5, ease: 'power2.inOut', transformOrigin: '50% 50%' });
                wrapper.classList.remove('trigger-active');
            }

            if (useGranteeTrigger) {
                document.addEventListener('mouseover', function(e) {
                    if (e.target.closest(triggerSelector)) toDiamond();
                });
                document.addEventListener('mouseout', function(e) {
                    if (e.target.closest(triggerSelector) && (!e.relatedTarget || !e.relatedTarget.closest(triggerSelector)))
                        toSquare();
                });
            } else {
                var trigger = wrapper.querySelector('.entry-hero-diamond-trigger');
                if (!trigger) return;
                trigger.addEventListener('mouseenter', toDiamond);
                trigger.addEventListener('mouseleave', toSquare);
            }
        });
    }
})();
</script>
