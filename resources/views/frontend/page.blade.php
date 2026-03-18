@extends('frontend.layout.layout')

@section('title-meta')

    <title>Section | AFAC</title>
    <meta property="og:title" content="">
    <meta name="description" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:type" content="website">

@endsection

@section('content')

    <div class="fullContainer">
        
        @if(@$logoAnimation==1)
            @foreach($logoElements as $logoElement)
                <input type="hidden" value="{{$logoElement->name}}" text="{{$logoElement->text}}" text_arabic="{{$logoElement->text_arabic}}" status="{{$logoElement->status}}" />
            @endforeach
            <div class="section">
                @include('components.animated-logo')
            </div>
        @endif

        {!! $pageHTML !!}
    
    </div>
    
@endsection