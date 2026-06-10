<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/images/favicon.png') }}" />
    <title>500 &mdash; {{ app()->getLocale() === 'ar' ? 'خطأ في الخادم' : 'Server Error' }}</title>

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/general.css') }}?v=8" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}?v=23" />
    <link rel="stylesheet" href="{{ asset('frontend/css/elements.css') }}?v=24" />
    @if(app()->getLocale() === 'ar')
    <link rel="stylesheet" href="{{ asset('frontend/css/arabic.css') }}?v=16" />
    @endif

    <script src="{{ asset('frontend/js/jquery.js') }}"></script>

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        .error-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
            background-color: #fff;
        }

        .error-logo {
            margin-bottom: 48px;
        }

        .error-code {
            font-size: clamp(80px, 18vw, 160px);
            line-height: 1;
            font-family: 'ABCDiatypeBlack', sans-serif;
            color: #000;
            letter-spacing: -4px;
        }

        .error-divider {
            width: 60px;
            height: 2px;
            background: #000;
            margin: 15px auto;
        }

        .error-title {
            font-size: clamp(18px, 3vw, 26px);
            font-family: 'ABCDiatypeMedium', sans-serif;
            color: #000;
            margin-bottom: 12px;
        }

        .error-description {
            font-size: clamp(13px, 2vw, 16px);
            color: #555;
            max-width: 460px;
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .error-btn {
            display: inline-block;
            padding: 8px 25px;
            border: 2px solid #000;
            color: #000;
            font-family: 'ABCDiatypeMedium', sans-serif;
            font-size: 14px;
            text-decoration: none;
            letter-spacing: 0.05em;
            transition: background 0.3s, color 0.3s;
        }

        .error-btn:hover {
            background: #000;
            color: #fff !important;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="error-page">

        <div class="error-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('frontend/images/logo.svg') }}" width="150px" alt="AFAC Logo" />
            </a>
        </div>

        <div class="error-code ABCDiatypeBlack">500</div>

        <div class="error-divider"></div>

        <div class="error-title ABCDiatypeMedium">
            @if(app()->getLocale() === 'ar')
                خطأ في الخادم
            @else
                Server Error
            @endif
        </div>

        <p class="error-description">
            @if(app()->getLocale() === 'ar')
                عذراً، حدث خطأ غير متوقع. نعمل على إصلاحه في أقرب وقت ممكن.
            @else
                Sorry, something went wrong on our end. We are working to fix it as soon as possible.
            @endif
        </p>

        <a href="{{ url('/') }}" class="error-btn">
            @if(app()->getLocale() === 'ar')
                العودة إلى الرئيسية
            @else
                Back to Home
            @endif
        </a>

    </div>
</body>

</html>
