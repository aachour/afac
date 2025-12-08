@extends('frontend.layout.layout')

@section('title-meta')
    <title>Animation | AFAC</title>
    <meta property="og:title" content="">
    <meta name="description" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta property="og:url" content="">
    <meta property="og:type" content="website">
@endsection

@section('content')
    <div style="padding: 40px; background: #f5f5f5;">
        <h2 style="margin-bottom: 30px;">Card Hover Animation Demo</h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            @component('frontend.card-hover-animation', ['text' => 'Apply Now', 'size' => 'small'])
                <div
                    style="width: 100%; height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    Small Card
                </div>
            @endcomponent

            @component('frontend.card-hover-animation', ['text' => 'Apply Now', 'size' => 'medium'])
                <div
                    style="width: 100%; height: 400px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    Medium Card
                </div>
            @endcomponent

            @component('frontend.card-hover-animation', ['text' => 'View Details', 'size' => 'large'])
                <div
                    style="width: 100%; height: 400px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    Large Card
                </div>
            @endcomponent

            @component('frontend.card-hover-animation', ['text' => 'Learn More', 'size' => 'large'])
                <div
                    style="width: 100%; height: 400px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    Custom Text
                </div>
            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            @include('frontend.donate-animation.circle-diamond')
        </div>
        <div class="col-lg-4">
            @include('frontend.donate-animation.circle-square')
        </div>
        <div class="col-lg-4">
            @include('frontend.donate-animation.diamond-square')
        </div>
        <div class="col-lg-4">
            @include('frontend.donate-animation.diamond-circle')
        </div>
        <div class="col-lg-4">
            @include('frontend.donate-animation.square-circle')
        </div>
        <div class="col-lg-4">
            @include('frontend.donate-animation.square-diamond')
        </div>
    </div>

    <div class="w-100 text-center mb-5">
        @include('components.animated-logo')
    </div>
@endsection
