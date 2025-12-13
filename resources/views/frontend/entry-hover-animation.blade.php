@php
    $text = $text ?? 'Apply Now';
    $size = $size ?? 'medium';
    $diamondColor = $diamondColor ?? '#E3F2FD'; 
    $textColor = $textColor ?? '#010101'; 
@endphp


@php
    $sizes = [
        'small' => [
            'diamond' => 160,
            'fontSize' => 18,
            'lineHeight' => 20,
            'padding' => 12
        ],
        'medium' => [
            'diamond' => 200,
            'fontSize' => 20,
            'lineHeight' => 22,
            'padding' => 16
        ],
        'large' => [
            'diamond' => 240,
            'fontSize' => 24,
            'lineHeight' => 26,
            'padding' => 20
        ]
    ];
    
    $config = $sizes[$size] ?? $sizes['medium'];
    $diamondSize = $config['diamond'];
    $center = $diamondSize / 2;
    $textLines = explode(' ', $text);
    $line1 = $textLines[0] ?? '';
    $line2 = implode(' ', array_slice($textLines, 1)) ?? '';
@endphp

    <!-- GSAP Library -->
    <script src="{{asset('frontend/js/gsap.js')}}"></script>

    <style>
        .card-hover-animation-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
            height: 100%;
        }

        .card-hover-animation-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 100;
            opacity: 0;
        }

        .card-hover-animation-diamond {
            transform-origin: center center;
        }

        .card-hover-animation-text {
            pointer-events: none;
            user-select: none;
        }
    </style>

    <div class="card-hover-animation-wrapper" data-hover-animation>

        @if($featured==1)
            <img src="{{$image_path}}" width="100%" />
        @else
            <a href="{{ $entry_href }}" target="{{$entry_target}}">
                <img src="{{$image_path}}" width="100%" />
                <div class="description">
                    <div class="title_or_labels medium white ABCDiatypeMedium" style="{{$title_position}}">{{$entry_title}}</div>
                    @if($with_label==1)
                        <div class="title_or_labels" style="{{$labels_position}};">
                            <div class="label micro black ABCDiatypeMedium">{{$entry_type_name}}</div>
                            @if($collection_type_id==1)
                                <div class="label micro black rounded ABCDiatypeMedium">{{date('d M',strtotime($event_date))}}</div>
                                <div class="clear"></div>
                                <div class="topSpacerSmall label micro black rounded ABCDiatypeMedium">{{date('h:i',strtotime($event_start_time))}} - {{date('h:i',strtotime($event_end_time))}}</div>
                                <div class="clear">&nbsp;</div>
                            @endif
                        </div>
                    @endif
                </div>
            </a>
        @endif
        
        <svg class="card-hover-animation-overlay" width="{{ $diamondSize }}" height="{{ $diamondSize }}" 
            viewBox="0 0 {{ $diamondSize }} {{ $diamondSize }}" fill="none" 
            xmlns="http://www.w3.org/2000/svg">
            <!-- Diamond shape - rotated square -->
            <g transform="translate({{ $center }}, {{ $center }}) rotate(-45)">
                <rect class="card-hover-animation-diamond" 
                    x="{{ -$diamondSize * 0.3535 }}" 
                    y="{{ -$diamondSize * 0.3535 }}" 
                    width="{{ $diamondSize * 0.707 }}" 
                    height="{{ $diamondSize * 0.707 }}" 
                    rx="4" 
                    fill="{{ $diamondColor }}"/>
            </g>
            
            <!-- Text inside diamond - not rotated, centered -->
            <text class="card-hover-animation-text" 
                x="{{ $center }}" 
                y="{{ $center - ($config['lineHeight'] * 0.4) }}" 
                fill="{{ $textColor }}" 
                font-family="Arial, sans-serif" 
                font-size="{{ $config['fontSize'] }}" 
                font-weight="bold" 
                text-anchor="middle"
                dominant-baseline="central">
                {{ $line1 }}
            </text>
            @if($line2)
            <text class="card-hover-animation-text" 
                x="{{ $center }}" 
                y="{{ $center + ($config['lineHeight'] * 0.6) }}" 
                fill="{{ $textColor }}" 
                font-family="Arial, sans-serif" 
                font-size="{{ $config['fontSize'] }}" 
                font-weight="bold" 
                text-anchor="middle"
                dominant-baseline="central">
                {{ $line2 }}
            </text>
            @endif
        </svg>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrappers = document.querySelectorAll('[data-hover-animation]');
            
            wrappers.forEach(function(wrapper) {
                const overlay = wrapper.querySelector('.card-hover-animation-overlay');
                const diamond = wrapper.querySelector('.card-hover-animation-diamond');
                
                if (!overlay || !diamond) return;
                
                // Set initial state
                gsap.set(overlay, {
                    opacity: 0,
                    scale: 0.8
                });
                
                wrapper.addEventListener('mouseenter', function() {
                
                    gsap.to(overlay, {
                        opacity: 1,
                        scale: 1,
                        duration: 0.8,
                        ease: "power2.out"
                    });
                });
                
                wrapper.addEventListener('mouseleave', function() {
                    
                    gsap.to(overlay, {
                        opacity: 0,
                        scale: 0.8,
                        duration: 0.5,
                        ease: "power2.in"
                    });
                });
            });
        });
    </script>

