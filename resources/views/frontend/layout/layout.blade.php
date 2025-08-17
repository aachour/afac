<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('frontend/images/favicon.png')}}" />

    @php
        $title = ucwords(str_replace('.', '-', request()->route()->getName()));
        $title = ucwords(str_replace('-', ' ', $title));
    @endphp

    @yield('title-meta')

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/plugins.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>

<body>

    <div class="wrapper d-flex flex-column justify-between" >
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top bg-white">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{asset('frontend/images/logo.png')}}" alt="" />
                </a>

                <!-- Navbar toggler button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="navbar-toggler-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>

                <!-- Navbar content -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <div class="navbar-content-inner ms-lg-auto d-flex flex-column flex-lg-row align-lg-center gap-4 gap-lg-10 p-2 p-lg-0">
                        <ul class="navbar-nav gap-lg-2 gap-xl-5">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('/') ? "active" : "" }}" href="{{route('home')}}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('about') ? "active" : "" }}" href="{{route('about')}}">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('our-solutions') ? "active" : "" }} " href="{{route('solutions')}}">Our Solutions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('visionaries') ? "active" : "" }} " href="{{route('visionaries')}}">Invest in Visionaries</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('business-plan') ? "active" : "" }} " href="{{route('business-plan')}}">Pitch Now</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('contact') ? "active" : "" }} " href="{{route('contact')}}">Contact</a>
                            </li>

                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Pages
                                </a>
                                <ul class="dropdown-menu megamenu megamenu-cols-2">
                                    <li><a class="dropdown-item " href="about.html">About</a></li>
                                    <li><a class="dropdown-item " href="about-lite.html">About lite</a></li>
                                    <li><a class="dropdown-item " href="contact.html">Contact</a></li>
                                    <li><a class="dropdown-item " href="contact-lite.html">Contact lite</a></li>
                                    <li><a class="dropdown-item " href="blog.html">Blog</a></li>
                                    <li><a class="dropdown-item " href="blog-lite.html">Blog lite</a></li>
                                    <li><a class="dropdown-item " href="article.html">Article</a></li>
                                    <li><a class="dropdown-item " href="article-lite.html">Article lite</a></li>
                                    <li><a class="dropdown-item " href="use-cases.html">Use cases</a></li>
                                    <li><a class="dropdown-item " href="use-cases-lite.html">Use cases lite</a></li>
                                    <li><a class="dropdown-item " href="use-cases-details.html">Case details</a></li>
                                    <li><a class="dropdown-item " href="use-cases-details-lite.html">Case details lite</a></li>
                                    <li><a class="dropdown-item " href="pricing-plan.html">Pricing</a></li>
                                    <li><a class="dropdown-item " href="pricing-plan-lite.html">Pricing lite</a></li>
                                    <li><a class="dropdown-item" href="login.html">Login</a></li>
                                    <li><a class="dropdown-item" href="login-lite.html">Login lite</a></li>
                                    <li><a class="dropdown-item" href="register.html">Register</a></li>
                                    <li><a class="dropdown-item" href="register-lite.html">Register lite</a></li>
                                    <li><a class="dropdown-item" href="forgot-password.html">Forgot password</a></li>
                                    <li><a class="dropdown-item" href="forgot-password-lite.html">Forgot password lite</a></li>
                                    <li><a class="dropdown-item " href="404.html">404</a></li>
                                    <li><a class="dropdown-item " href="404-lite.html">404 lite</a></li>
                                </ul>
                            </li> --}}

                            {{-- <li class="nav-item">
                                <a class="nav-link" href="login.html">Login</a>
                            </li> --}}
                        </ul>
                        {{-- <div class="">
                            <a href="login.html" class="btn btn-outline-primary">Get started</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </nav>

        @yield('content');
        
        <!-- Footer -->
        <footer class="footer bg-color-blur pt-10 pt-lg-15">
            <div class="container">
                <div class="row g-10">
                    <div class="col-lg-9 col-xl-8 order-lg-2">
                        <div class="row g-6">
                            <div class="col-md-4 col-lg-6">
                                <div class="footer-widget text-center text-md-start">
                                    <h6 class=" mb-2"><span class="text-primary">11</span>B</h6>
                                    <ul class="link-list list-unstyled mb-0">
                                        <li>
                                            <a href="{{route('about')}}">About</a>
                                        </li>
                                        <li>
                                            <a href="{{route('solutions')}}">Our Solutions</a>
                                        </li>
                                        <li>
                                            <a href="{{route('visionaries')}}">Invest In Visionaries</a>
                                        </li>
                                        <li>
                                            <a href="{{route('business-plan')}}">Pitch Now</a>
                                        </li>
                                        <li>
                                            <a href="{{route('contact')}}">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-lg-6">
                                <div class="footer-widget text-center text-md-start">
                                    <h6 class=" mb-4">News & Update</h6>
                                    <form id="subscribe-form" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="email" name="subscribe-email" id="subscribe-email" class="form-control" placeholder="Enter your email" />
                                            <button type="button" class="btn btn-primary px-4" id="subscribeBtn">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4.031 8.917 15.477-4.334a.5.5 0 0 1 .616.617l-4.333 15.476a.5.5 0 0 1-.94.067l-3.248-7.382a.5.5 0 0 0-.256-.257L3.965 9.856a.5.5 0 0 1 .066-.94v0Z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                    <div id="subscribe-success" class="alert alert-success mt-3 d-none"></div>
                                    <ul class="list-unstyled d-flex flex-wrap align-center justify-center justify-md-start gap-3 social-list mb-0 mt-5">
                                        <li>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke="none" d="M0 0h24v24H0z" />
                                                    <path d="M9 19c-4.3 1.4-4.3-2.5-6-3m12 5v-3.5c0-1 .1-1.4-.5-2 2.8-.3 5.5-1.4 5.5-6a4.6 4.6 0 0 0-1.3-3.2 4.2 4.2 0 0 0-.1-3.2s-1.1-.3-3.5 1.3a12.3 12.3 0 0 0-6.2 0C6.5 2.8 5.4 3.1 5.4 3.1a4.2 4.2 0 0 0-.1 3.2A4.6 4.6 0 0 0 4 9.5c0 4.6 2.7 5.7 5.5 6-.6.6-.6 1.2-.5 2V21" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" class="icon icon-tabler icon-tabler-brand-dribbble" viewBox="0 0 24 24">
                                                    <path stroke="none" d="M0 0h24v24H0z" />
                                                    <circle cx="12" cy="12" r="9" />
                                                    <path d="M9 3.6c5 6 7 10.5 7.5 16.2" />
                                                    <path d="M6.4 19c3.5-3.5 6-6.5 14.5-6.4M3.1 10.75c5 0 9.814-.38 15.314-5" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6v6A3.75 3.75 0 0 1 12 15.75H6A3.75 3.75 0 0 1 2.25 12V6A3.75 3.75 0 0 1 6 2.25h6A3.75 3.75 0 0 1 15.75 6Z" />
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 15.75V9c0-1.641.375-3 3-3m-4.5 3.75h4.5" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 2.258s-1.514.894-2.355 1.147A3.36 3.36 0 0 0 9 5.655v.75a7.995 7.995 0 0 1-6.75-3.397s-3 6.75 3.75 9.75a8.73 8.73 0 0 1-5.25 1.5c6.75 3.75 15 0 15-8.625a3.34 3.34 0 0 0-.06-.623c.765-.754 1.56-2.752 1.56-2.752Z" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6v0Z" />
                                                    <path stroke="currentColor" stroke-width="1.5" d="M2.25 12V6A3.75 3.75 0 0 1 6 2.25h6A3.75 3.75 0 0 1 15.75 6v6A3.75 3.75 0 0 1 12 15.75H6A3.75 3.75 0 0 1 2.25 12Z" />
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 order-lg-1 me-auto">
                        <div class="footer-widget text-center text-lg-start">
                            <a href="{{route('home')}}">
                                <img src="{{asset('frontend/images/logo.png')}}" alt="" class="img-fluid" />
                            </a>
                            <p class="fs-sm mb-0 mt-3">Empowering Visionaries, Transforming Communities</p>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="text-center pt-1 pb-4">
                    <p class="fs-sm mb-0">
                        Copyright <span class="text-primary">11</span>B. &nbsp; Designed & Developed by <a href="https://binarycords.com" target="_blank">Binarycords</a>
                    </p>
                </div>

            </div>
        </footer>
        
    </div>
        
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $(document).ready(function() { 

            $('#subscribeBtn').click(function(e) { 
                e.preventDefault(); 

                var email = $("#subscribe-email").val();
                
                $.ajax({
                    url: '{{ route('subscribe.save') }}',
                    method: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}', 
                        'email': email
                    },
                    success: function(response) {
                        // Show success message
                        $('#subscribe-success').text(response).removeClass('alert-danger').removeClass('d-none'); 
                        // Reset the form fields
                        $('#subscribe-form')[0].reset(); 
                    },
                    error: function(xhr) {
                        $('#subscribe-success').text('Subscription failed. Please try again.').removeClass('d-none').addClass('alert-danger');
                    }
                });

            });
        });

    </script>


    <!-- JS -->
    <script src="{{asset('frontend/js/plugins.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
        
</body>
        
</html>