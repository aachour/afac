@extends('frontend.layout.layout')

@section('title-meta')

    <title>{{ $metaTitle }} | AFAC</title>
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:type" content="website">

@endsection

@section('content')

    <div class="fullContainer">

        @if(@$logoAnimation==1)
            <div class="section">
                @include('components.animated-logo', ['logoElements' => $logoElements])
            </div>
        @endif

        {!! $pageHTML !!}
    
    </div>
    
@endsection