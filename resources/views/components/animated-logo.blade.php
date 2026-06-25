{{--
  AFAC animated logo: afac-new-logo.svg with 8 elements.
  Animation 1 = diamond (rotate -45° + white text). Animation 2 = circle (scale pop + text). Animation 3 = vertical (cover slide + text).
  CMS: each element has name, text, status; only status=1 gets animation + its own text.
--}}
@php
    $logoElements = $logoElements ?? \App\Models\Logo::orderBy('id')->get();
    $logoConfig = [];
    foreach ($logoElements as $le) {
        $key = strtolower(preg_replace('/\s+/', '', trim((string) ($le->name ?? ''))));
        if ($key === '') continue;
        $key = str_replace('diamond', 'diamon', $key);
        $text= (string) ($le->text ?? '');
        if(app()->getLocale()=='ar')        {
            $text= (string) ($le->text_arabic ?? '');
        }
            
        $logoConfig[$key] = [
            'text' => $text,
            'status' => (int) ($le->status ?? 0),
        ];
    }
@endphp
<script src="{{ asset('frontend/js/gsap.js') }}"></script>
<script type="application/json" id="animated-logo-config">{!! json_encode($logoConfig, JSON_UNESCAPED_UNICODE) !!}</script>

<div class="animated-logo-wrapper" id="animated-logo-root">
    <svg class="animated-logo-svg" width="1200" height="600" viewBox="0 0 437 233" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g class="logo-container">
            {{-- Tiny connector (right vertical area) --}}
            <path fill="#010101" d="M381.88,163.82v1.66c0-.28.02-.55.02-.83s-.02-.55-.02-.83Z"/>

            {{-- Diamon 3 (right) - Animation 1 --}}
            <g class="logo-part" data-part="diamon3">
                <path class="diamon3-path" fill="#010101" d="M266.22,48.47l47.95,47.96,48.22-48.21L314.17,0l-47.95,47.96.25.26-.25.25Z"/>
                <g class="anim-diamon3-text" style="opacity:0;pointer-events:none"></g>
                <rect class="hover-diamon3" x="266" y="0" width="96" height="96" fill="transparent" style="cursor:pointer"/>
            </g>
            {{-- Diamon 1 (left) - Animation 1 --}}
            <g class="logo-part" data-part="diamon1">
                <path class="diamon1-path" fill="#010101" d="M170.08,48.25l-.04-.04.04-.03L121.9,0l-48.22,48.21,48.22,48.22,48.18-48.18Z"/>
                <g class="anim-diamon1-text" style="opacity:0;pointer-events:none"></g>
                <rect class="hover-diamon1" x="74" y="0" width="96" height="96" fill="transparent" style="cursor:pointer"/>
            </g>
            {{-- Diamon 2 (middle) - Animation 1 --}}
            <g class="logo-part" data-part="diamon2">
                <path class="diamon2-path" fill="#010101" d="M170.08,48.25l48.18,48.18,47.96-47.96-.26-.26.26-.25L218.26,0l-48.18,48.18.03.04-.03.03Z"/>
                <g class="anim-diamon2-text" style="opacity:0;pointer-events:none"></g>
                <rect class="hover-diamon2" x="170" y="0" width="96" height="96" fill="transparent" style="cursor:pointer"/>
            </g>
            <path fill="#010101" d="M266.22,47.98l-.25.25.25.25.26-.25-.26-.25Z"/>

            {{-- Vertical 1 (left column) - Animation 3 --}}
            <g class="logo-part" data-part="vertical1">
                <rect fill="#010101" x="1.62" y="98.02" width="54.12" height="134.53"/>
                <rect fill="#010101" x="55.74" y="221.7" width="69.58" height="10.79"/>
                <g class="anim-vertical1-content" style="opacity:0;pointer-events:none">
                    <rect x="1" y="85" width="55" height="55" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2" rx="2"/>
                </g>
                <rect class="cover-vertical1" x="1.5" y="95" width="54.2" height="60" fill="#010101"/>
                <rect class="hover-vertical1" x="0" y="90" width="56" height="145" fill="transparent" style="cursor:pointer"/>
            </g>

            {{-- Circle 1 (left O) - Animation 2 --}}
            <g class="logo-part" data-part="circle1">
                <path fill="#010101" d="M123.78,96.43c-37.57,0-68.03,30.46-68.03,68.03s30.46,68.03,68.03,68.03,68.03-30.46,68.03-68.03-30.46-68.03-68.03-68.03ZM123.78,175.51c-6.1,0-11.05-4.95-11.05-11.05s4.95-11.05,11.05-11.05,11.05,4.95,11.05,11.05-4.95,11.05-11.05,11.05Z"/>
                <g class="anim-circle1-content" style="opacity:0;pointer-events:none">
                    <circle cx="123.78" cy="164.46" r="40" fill="none" stroke="#010101" stroke-width="3"/>
                    <circle cx="123.78" cy="164.46" r="55" fill="#FFFFFF"/>
                </g>
                <circle class="hover-circle1" cx="123.78" cy="164.46" r="60" fill="transparent" style="cursor:pointer"/>
            </g>

            {{-- Vertical 2 (middle) - Animation 3 --}}
            <g class="logo-part" data-part="vertical2">
                <rect fill="#010101" x="191.81" y="98.25" width="54.12" height="134.53"/>
                <g class="anim-vertical2-content" style="opacity:0;pointer-events:none">
                    <rect x="192" y="96.5" width="54" height="55" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2" rx="2"/>
                </g>
                <rect class="cover-vertical2" x="192" y="98" width="53.9" height="60" fill="#010101"/>
                <rect class="hover-vertical2" x="185" y="80" width="68" height="145" fill="transparent" style="cursor:pointer"/>
            </g>

            {{-- Circle 2 (right O) - Animation 2 --}}
            <g class="logo-part" data-part="circle2">
                <path fill="#010101" d="M313.96,96.66c-37.57,0-68.03,30.46-68.03,68.03s30.46,68.03,68.03,68.03,68.03-30.46,68.03-68.03-30.46-68.03-68.03-68.03ZM313.96,175.74c-6.1,0-11.05-4.95-11.05-11.05s4.95-11.05,11.05-11.05,11.05,4.95,11.05,11.05-4.95,11.05-11.05,11.05Z"/>
                <g class="anim-circle2-content" style="opacity:0;pointer-events:none">
                    <circle cx="313.96" cy="164.69" r="40" fill="none" stroke="#010101" stroke-width="3"/>
                    <circle cx="313.96" cy="164.69" r="55" fill="#FFFFFF"/>
                </g>
                <circle class="hover-circle2" cx="313.96" cy="164.69" r="60" fill="transparent" style="cursor:pointer"/>
            </g>

            <rect fill="#010101" x="245.93" y="221.93" width="69.58" height="10.79"/>

            {{-- Vertical 3 (right) - Animation 3 --}}
            <g class="logo-part" data-part="vertical3">
                <rect fill="#010101" x="381.99" y="96.56" width="54.12" height="134.53"/>
                <g class="anim-vertical3-content" style="opacity:0;pointer-events:none">
                    <rect x="381" y="85" width="55" height="55" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2" rx="2"/>
                </g>
                <rect class="cover-vertical3" x="382" y="95" width="54.2" height="60" fill="#010101"/>
                <rect class="hover-vertical3" x="380" y="90" width="60" height="145" fill="transparent" style="cursor:pointer"/>
            </g>
        </g>
    </svg>
</div>

<style>
    .animated-logo-wrapper { display: block; width: 80%; margin: 0 auto; cursor: pointer; position: relative; }
    .animated-logo-svg { display: block; width: 100%; max-width: none; height: auto; }
    .animated-logo-wrapper.logo-in-navbar { width: 100px; margin: 0; }
    .animated-logo-wrapper.logo-in-navbar text { opacity: 0 !important; visibility: hidden !important; }
    .logo-part[data-inactive="1"] [class^="hover-"] { pointer-events: none !important; cursor: default !important; }
    .header-logo-title.is-replaced-by-logo { display: none !important; }
</style>

<script>
(function() {
    function parseConfig() {
        var el = document.getElementById('animated-logo-config');
        if (!el) return {};
        try { return JSON.parse(el.textContent) || {}; } catch (e) { return {}; }
    }
    function active(cfg, key) {
        var c = cfg[key];
        return c && Number(c.status) === 1;
    }
    function splitLines(s) {
        if (!s) return [];
        return String(s).split(/\r?\n/).map(function(t) { return t.trim(); }).filter(Boolean);
    }

    document.addEventListener('DOMContentLoaded', function() {
        var cfg = parseConfig();
        var root = document.getElementById('animated-logo-root');
        if (!root) return;
        var ns = 'http://www.w3.org/2000/svg';
        var labelFontFamily = "'ABC Diatype Arabic'";
        var logoContainer = root.querySelector('.logo-container');
        var measureTextNode = document.createElementNS(ns, 'text');
        measureTextNode.setAttribute('font-family', labelFontFamily);
        measureTextNode.setAttribute('visibility', 'hidden');
        if (logoContainer) logoContainer.appendChild(measureTextNode);
        function measureWidth(text, fontSize) {
            if (!measureTextNode) return String(text || '').length * fontSize * 0.6;
            measureTextNode.setAttribute('font-size', String(fontSize));
            measureTextNode.textContent = text;
            return measureTextNode.getComputedTextLength();
        }
        function wrapTextLines(s, maxWidth, fontSize) {
            var raw = splitLines(s);
            var out = [];
            for (var i = 0; i < raw.length; i++) {
                var words = String(raw[i] || '').split(/\s+/).filter(Boolean);
                if (!words.length) continue;
                var current = '';
                for (var j = 0; j < words.length; j++) {
                    var word = words[j];
                    var candidate = current ? (current + ' ' + word) : word;
                    if (current && measureWidth(candidate, fontSize) > maxWidth) {
                        out.push(current);
                        current = word;
                    } else {
                        current = candidate;
                    }
                }
                if (current) out.push(current);
            }
            return out;
        }

        function setInactive(part, inactive) {
            var g = root.querySelector('[data-part="' + part + '"]');
            if (g) g.setAttribute('data-inactive', inactive ? '1' : '0');
        }
        function isNavbarLogo() {
            return root.classList.contains('logo-in-navbar');
        }
        function applyLabelTextAttrs(textNode, fill, fontSize) {
            textNode.setAttribute('fill', fill);
            textNode.setAttribute('font-family', labelFontFamily);
            textNode.setAttribute('font-size', String(fontSize));
            textNode.setAttribute('text-anchor', 'middle');
            textNode.setAttribute('dominant-baseline', 'middle');
        }

        // ---- Animation 1: Diamonds (rotate -45 + white text) ----
        var diamondCenters = { diamon1: '121.9 48.21', diamon2: '218.26 48.21', diamon3: '314.17 48.21' };
        ['diamon1', 'diamon2', 'diamon3'].forEach(function(key) {
            if (!active(cfg, key)) { setInactive(key, true); return; }
            setInactive(key, false);
            var path = root.querySelector('.' + key + '-path');
            var hover = root.querySelector('.hover-' + key);
            var textG = root.querySelector('.anim-' + key + '-text');
            var lines = wrapTextLines((cfg[key] || {}).text || 'Established in 2007', 54, 9);
            if (textG) {
                textG.innerHTML = '';
                var cx = key === 'diamon1' ? 121.9 : key === 'diamon2' ? 218.26 : 314.17;
                var cy = 48.21;
                var gap = 11;
                var total = lines.length;
                var firstY = cy - ((total - 1) * gap) / 2;
                lines.forEach(function(line, i) {
                    var t = document.createElementNS(ns, 'text');
                    t.setAttribute('x', cx);
                    t.setAttribute('y', firstY + i * gap);
                    applyLabelTextAttrs(t, '#FFFFFF', 9);
                    t.textContent = line;
                    textG.appendChild(t);
                });
            }
            if (!path || !hover) return;
            var origin = diamondCenters[key];
            hover.addEventListener('mouseenter', function() {
                gsap.killTweensOf([path, textG]);
                gsap.to(path, { rotation: -45, duration: 0.7, svgOrigin: origin });
                if (textG && !isNavbarLogo()) gsap.to(textG, { opacity: 1, duration: 0.3, delay: 0.2 });
            });
            hover.addEventListener('mouseleave', function() {
                gsap.killTweensOf([path, textG]);
                if (textG && !isNavbarLogo()) gsap.to(textG, { opacity: 0, duration: 0.3 });
                gsap.to(path, { rotation: 0, duration: 0.7, svgOrigin: origin });
            });
        });

        // ---- Animation 2: Circles (scale pop + text) ----
        var circleData = [
            { key: 'circle1', hover: '.hover-circle1', content: '.anim-circle1-content', cx: 123.78, cy: 164.46 },
            { key: 'circle2', hover: '.hover-circle2', content: '.anim-circle2-content', cx: 313.96, cy: 164.69 }
        ];
        circleData.forEach(function(c) {
            if (!active(cfg, c.key)) { setInactive(c.key, true); return; }
            setInactive(c.key, false);
            var content = root.querySelector(c.content);
            var hover = root.querySelector(c.hover);
            if (content) gsap.set(content, { scale: 0, svgOrigin: c.cx + ' ' + c.cy });
            var lines = wrapTextLines((cfg[c.key] || {}).text || 'Supporting 2,000 initiatives and counting', 97, 9);
            if (content) {
                var existing = content.querySelectorAll('text');
                for (var i = 0; i < existing.length; i++) existing[i].remove();
                var gap = 11;
                var total = lines.length;
                var startY = c.cy - ((total - 1) * gap) / 2;
                lines.forEach(function(line, i) {
                    var t = document.createElementNS(ns, 'text');
                    t.setAttribute('x', c.cx);
                    t.setAttribute('y', startY + i * gap);
                    applyLabelTextAttrs(t, '#010101', 9);
                    t.textContent = line;
                    content.appendChild(t);
                });
            }
            if (!hover || !content) return;
            var origin = c.cx + ' ' + c.cy;
            hover.addEventListener('mouseenter', function() {
                gsap.killTweensOf(content);
                gsap.to(content, { opacity: 1, scale: 1, duration: 0.5, ease: 'power2.out', svgOrigin: origin });
            });
            hover.addEventListener('mouseleave', function() {
                gsap.killTweensOf(content);
                gsap.to(content, { opacity: 0, scale: 0, duration: 0.5, ease: 'power2.in', svgOrigin: origin });
            });
        });

        // ---- Animation 3: Verticals (cover slides down to reveal text) ----
        var verticalTextPaddingTop = 5;
        var verticalData = [
            { key: 'vertical1', cover: '.cover-vertical1', hover: '.hover-vertical1', content: '.anim-vertical1-content', tx: 28, ty: 112 },
            { key: 'vertical2', cover: '.cover-vertical2', hover: '.hover-vertical2', content: '.anim-vertical2-content', tx: 218, ty: 112 },
            { key: 'vertical3', cover: '.cover-vertical3', hover: '.hover-vertical3', content: '.anim-vertical3-content', tx: 408, ty: 112 }
        ];
        verticalData.forEach(function(v) {
            if (!active(cfg, v.key)) { setInactive(v.key, true); return; }
            setInactive(v.key, false);
            var cover = root.querySelector(v.cover);
            var hover = root.querySelector(v.hover);
            var content = root.querySelector(v.content);
            var lines = wrapTextLines((cfg[v.key] || {}).text || 'Based in Beirut', 50, 9);
            if (content) {
                var existing = content.querySelectorAll('text');
                for (var i = 0; i < existing.length; i++) existing[i].remove();
                var gap = 11;
                var startY = v.ty + verticalTextPaddingTop - ((lines.length - 1) * gap) / 2;
                lines.forEach(function(line, i) {
                    var t = document.createElementNS(ns, 'text');
                    t.setAttribute('x', v.tx);
                    t.setAttribute('y', startY + i * gap);
                    applyLabelTextAttrs(t, '#010101', 9);
                    t.textContent = line;
                    content.appendChild(t);
                });
            }
            if (!hover || !cover) return;
            hover.addEventListener('mouseenter', function() {
                if (content) gsap.killTweensOf(content);
                gsap.killTweensOf(cover);
                if (content) gsap.set(content, { opacity: 1 });
                gsap.to(cover, { y: 60, duration: 1.1, ease: 'power2.out' });
            });
            hover.addEventListener('mouseleave', function() {
                if (content) gsap.killTweensOf(content);
                gsap.killTweensOf(cover);
                gsap.to(cover, { y: 0, duration: 0.85, ease: 'power2.in' });
                if (content) gsap.set(content, { opacity: 0, delay: 0.9 });
            });
        });

        // ---- Click: animate into navbar logo slot ----
        var logoWrapper = root;
        var logoSvg = root.querySelector('.animated-logo-svg');
        var isMinimized = false;
        if (logoWrapper && logoSvg) {
            logoWrapper.addEventListener('click', function(e) {
                e.stopPropagation();
                if (isMinimized) return;
                isMinimized = true;
                var headerLogoAnchor = document.querySelector('.header .logo a') || document.querySelector('.header .logo');
                var headerTitle = document.getElementById('header-logo-title');
                var targetLogo = headerTitle || document.querySelector('.header .logo img');
                if (!headerLogoAnchor) {
                    isMinimized = false;
                    return;
                }

                var headerLogoEl = document.querySelector('.header .logo');
                var sourceRect = logoWrapper.getBoundingClientRect();
                var targetRect = targetLogo ? targetLogo.getBoundingClientRect() : headerLogoAnchor.getBoundingClientRect();
                var slotRect = (headerLogoEl && headerTitle)
                    ? headerLogoEl.getBoundingClientRect()
                    : targetRect;
                var endWidth = headerTitle ? 100 : targetRect.width;
                var endHeight = headerTitle
                    ? (sourceRect.width > 0 ? sourceRect.height * (endWidth / sourceRect.width) : targetRect.height)
                    : targetRect.height;
                var isRtl = document.documentElement.getAttribute('dir') === 'rtl';
                var endLeft = (headerTitle && isRtl)
                    ? slotRect.right - endWidth
                    : targetRect.left;
                var endTop = headerTitle
                    ? targetRect.top + Math.max(0, (targetRect.height - endHeight) / 2)
                    : targetRect.top;

                if (headerLogoEl && headerTitle) {
                    headerLogoEl.style.width = slotRect.width + 'px';
                    headerLogoEl.style.flexShrink = '0';
                    headerLogoEl.style.justifyContent = isRtl ? 'flex-end' : 'flex-start';
                }

                // Prevent white overlays flashing while morphing to navbar size.
                gsap.set([
                    '.anim-diamon1-text', '.anim-diamon2-text', '.anim-diamon3-text',
                    '.anim-circle1-content', '.anim-circle2-content'
                ], { opacity: 0, scale: 0 });
                gsap.set(['.cover-vertical1', '.cover-vertical2', '.cover-vertical3'], { y: 0 });
                gsap.set(['.diamon1-path', '.diamon2-path', '.diamon3-path'], { rotation: 0 });

                // Keep layout stable while the logo is temporarily fixed.
                var placeholder = document.createElement('div');
                placeholder.style.width = sourceRect.width + 'px';
                placeholder.style.height = sourceRect.height + 'px';
                logoWrapper.parentNode.insertBefore(placeholder, logoWrapper);

                logoWrapper.style.pointerEvents = 'none';
                logoWrapper.style.position = 'fixed';
                logoWrapper.style.left = sourceRect.left + 'px';
                logoWrapper.style.top = sourceRect.top + 'px';
                logoWrapper.style.width = sourceRect.width + 'px';
                logoWrapper.style.height = sourceRect.height + 'px';
                logoWrapper.style.margin = '0';
                logoWrapper.style.zIndex = '10000';

                if (headerTitle) {
                    gsap.to(headerTitle, { opacity: 0, duration: 0.5, ease: 'power2.in' });
                }

                gsap.to(logoWrapper, {
                    left: endLeft,
                    top: endTop,
                    width: endWidth,
                    height: endHeight,
                    duration: 0.9,
                    ease: 'power2.inOut',
                    onComplete: function() {
                        if (headerTitle) {
                            headerTitle.classList.add('is-replaced-by-logo');
                        } else if (targetLogo && targetLogo.tagName === 'IMG') {
                            targetLogo.style.display = 'none';
                        }
                        headerLogoAnchor.appendChild(logoWrapper);
                        logoWrapper.classList.add('logo-in-navbar');
                        if (headerLogoEl) {
                            headerLogoEl.style.width = endWidth + 'px';
                            headerLogoEl.style.flexShrink = '0';
                        }
                        gsap.set(logoWrapper, { clearProps: 'left,top,width,height,right' });
                        logoWrapper.style.position = 'relative';
                        logoWrapper.style.left = '';
                        logoWrapper.style.top = '';
                        logoWrapper.style.right = '';
                        logoWrapper.style.width = endWidth + 'px';
                        logoWrapper.style.height = 'auto';
                        logoWrapper.style.margin = '0';
                        logoWrapper.style.zIndex = '';
                        logoWrapper.style.pointerEvents = 'auto';
                        gsap.set(['.anim-circle1-content', '.anim-circle2-content'], { scale: 0, opacity: 0 });
                        gsap.set(['.anim-diamon1-text', '.anim-diamon2-text', '.anim-diamon3-text'], { opacity: 0 });
                        gsap.set(['.anim-vertical1-content', '.anim-vertical2-content', '.anim-vertical3-content'], { opacity: 0 });
                        if (placeholder && placeholder.parentNode) {
                            placeholder.parentNode.removeChild(placeholder);
                        }
                        document.dispatchEvent(new CustomEvent('animatedLogo:minimized'));
                    }
                });
            });
        }
    });
})();
</script>
