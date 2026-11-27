@php $isAr = app()->getLocale() == 'ar'; @endphp
<form class="site-search {{ $class ?? '' }}" action="{{ url('/search') }}" method="get" novalidate>
    <div class="site-search-field">
        <input type="text" name="q" class="site-search-input" autocomplete="off"
               placeholder="{{ $isAr ? 'بحث...' : 'Search...' }}" aria-label="{{ $isAr ? 'بحث' : 'Search' }}"
               value="{{ request()->routeIs('search') ? request()->route('term') : '' }}">
        <button type="submit" class="site-search-btn clickable" aria-label="{{ $isAr ? 'بحث' : 'Search' }}">
            <img src="{{ asset('frontend/images/search-icon.svg') }}" alt="" width="26" height="26">
        </button>
    </div>
    <div class="site-search-error small"aria-live="polite">{{ $isAr ? 'يجب أن يتكون البحث من 3 أحرف على الأقل' : 'Search must be at least 3 characters' }}</div>
</form>
