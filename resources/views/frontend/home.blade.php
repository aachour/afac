@extends('frontend.layout.layout')

@section('title-meta')

    <title>11B | Empowering Visionary Entrepreneurs with Mentorship, Resources & Funding</title>
    <meta property="og:title" content="11B | Empowering Visionary Entrepreneurs with Mentorship, Resources & Funding">
    
    <meta name="description" content="At 11B, we help entrepreneurs turn bold ideas into thriving businesses with expert mentorship, strategic funding, and cutting-edge resources. Based in Dearborn, Michigan, our startup accelerator fosters innovation, collaboration, and economic growth. Join our network and transform your vision into reality!">
    <meta property="og:description" content="At 11B, we help entrepreneurs turn bold ideas into thriving businesses with expert mentorship, strategic funding, and cutting-edge resources. Based in Dearborn, Michigan, our startup accelerator fosters innovation, collaboration, and economic growth. Join our network and transform your vision into reality!">

    <meta property="og:image" content="https://11b.vc/frontend/images/logo.png">
    <meta property="og:url" content="https://11b.vc/">
    <meta property="og:type" content="website">

@endsection

@section('content')

<main class="flex-grow-1">

    <!-- Hero -->
    <section class="hero-section style-2 position-relative mt-10">
        <div class="striped-shape">
            <img src="{{asset('frontend/images/shapes/stripe-light.svg')}}" alt="" />
        </div>
        <div class="container">
            <div class="row align-center">
                <h2 class="text-primary text-center mb-18 lato" data-aos="fade-up-sm" data-aos-delay="50">
                    Empowering<span class="text-black px-4 py-2 d-inline-block lato">Visionaries, Building the</span><span
                        class="text-danger lato">Future</span>
                </h2>
                <div class="col-lg-5">
                    <div class="text-center text-lg-start position-relative z-1">
                        <h2 class="mb-8" data-aos="fade-up-sm" data-aos-delay="100">
                            Where Ambition Meets Opportunity
                        </h2>
                        <h5 class=" mb-8" data-aos="fade-up-sm" data-aos-delay="100">
                            <span class="text-primary">At 11B</span>, we believe the future belongs to those who dare to
                            innovate.
                            Our mission is to empower visionary entrepreneurs with the resources,
                            mentorship, and capital needed to turn groundbreaking ideas into reality.
                            We foster a vibrant startup ecosystem in Dearborn, Michigan, and beyond,
                            where ambition meets opportunity and innovation drives economic growth.
                        </h5>
                        <div class="mt-12">
                            <a href="{{route('visionReality')}}" class="btn btn-primary">Get Started Today</a>
                            <div class="mt-2 onlyMobile"></div>
                            <a href="#our-program" class="btn btn-secondary">Learn More About 11B</a>
                        </div>

                    </div>
                </div>


                <div class="col-lg-7" data-aos="fade-up-sm" data-aos-delay="200">
                    <div class="mt-12 rounded-4 border shadow-lg overflow-hidden position-relative">
                        <img class="img-fluid d-inline-block w-100"
                            src="{{ asset('frontend/images/screens/screen-9.jpeg') }}" alt="" />
                        <div class="position-absolute top-50 start-50 translate-middle text-center fw-bold">
                            <p class="m-0 fs-4">
                                <span class="text-primary me-2">Empowering</span>
                                <span class="text-black">Visionaries</span>
                            </p>
                            <p class="m-0 fs-4">
                                <span class="text-black me-2">Building the</span>
                                <span class="text-danger">Future</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </section>


    <!-- Our Program -->
    <section id="our-program" class="features-section has-blurry-shape position-relative overflow-hidden mt-30">
        <div class="blurry-shape">
            <img src="{{asset('frontend/images/shapes/blurry-shape-3.svg')}}" alt="" class="img-fluid" />
        </div>
        <div class="container">
            <div class="text-center mb-10">
                <h2 class="text-primary text-center mb-10" data-aos="fade-up-sm" data-aos-delay="50">
                    <span class="border px-4 py-2 rounded-3 d-inline-block">Our Program</span>
                </h2>
                <h2 class="mb-0" data-aos="fade-up-sm" data-aos-delay="50">
                    Comprehensive Support for Startups
                </h2>
                <h5 class=" mb-0 mt-3" data-aos="fade-up-sm" data-aos-delay="50">
                    <span class="text-primary">At 11B</span>, we provide tailored programs to help entrepreneurs at
                    every stage of their journey.
                    From refining ideas to scaling thriving businesses, our comprehensive support system equips startups
                    with the tools,
                    mentorship, and funding they need to succeed. Whether you’re building a product, growing your market
                    presence, or preparing for investment,
                    we’re here to accelerate your progress.
                </h5>
            </div>

            <div class="row mt-2 g-3">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="row g-3">
                        <div class="col-lg-4 col-sm-12">
                            <div class="card border-1 bg-card rounded-3 p-2">
                                <div class="card-header bg-transparent border-0 ">
                                    <img src="{{ asset('frontend/images/brands/13.png') }}" alt="" class="img-fluid"
                                        style="height: 50px;">
                                </div>
                                <div class="card-body">
                                    <h6 class="text-primary fw-semibold">Empowering Entrepreneurs</h6>
                                    <p class="text-secondary mb-0">On</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card border-1 bg-card rounded-3 p-2">
                                <div class="card-header bg-transparent border-0 ">
                                    <img src="{{ asset('frontend/images/brands/12.png') }}" alt="" class="img-fluid"
                                        style="height: 50px;">
                                </div>
                                <div class="card-body">
                                    <h6 class="text-primary fw-semibold">Fostering Innovation</h6>
                                    <p class="text-secondary mb-0">On</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card border-1 bg-card rounded-3 p-2">
                                <div class="card-header bg-transparent border-0 ">
                                    <img src="{{ asset('frontend/images/brands/14.png') }}" alt="" class="img-fluid"
                                        style="height: 50px;">
                                </div>
                                <div class="card-body">
                                    <h6 class="text-primary fw-semibold">Community Impact</h6>
                                    <p class="text-secondary mb-0">On</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card border-1 bg-card rounded-3 p-2">
                                <div class="card-header bg-transparent border-0 ">
                                    <img src="{{ asset('frontend/images/brands/10.png') }}" alt="" class="img-fluid"
                                        style="height: 50px;">
                                </div>
                                <div class="card-body">
                                    <h6 class="text-primary fw-semibold">Initial Application</h6>
                                    <p class="text-secondary mb-0">On</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card border-1 bg-card rounded-3 p-2">
                                <div class="card-header bg-transparent border-0 ">
                                    <img src="{{ asset('frontend/images/brands/8.png') }}" alt="" class="img-fluid"
                                        style="height: 50px;">
                                </div>
                                <div class="card-body">
                                    <h6 class="text-primary fw-semibold">Pitch Presentation</h6>
                                    <p class="text-secondary mb-0">On</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card border-1 bg-card rounded-3 p-2">
                                <div class="card-header bg-transparent border-0 ">
                                    <img src="{{ asset('frontend/images/brands/11.png') }}" alt="" class="img-fluid"
                                        style="height: 50px;">
                                </div>
                                <div class="card-body">
                                    <h6 class="text-primary fw-semibold">Fund Investment</h6>
                                    <p class="text-secondary mb-0">On</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card border-1 bg-card rounded-3 p-2">
                                <div class="card-header bg-transparent border-0 ">
                                    <img src="{{ asset('frontend/images/brands/6.png') }}" alt="" class="img-fluid"
                                        style="height: 50px;">
                                </div>
                                <div class="card-body">
                                    <h6 class="text-primary fw-semibold">Success Stories</h6>
                                    <p class="text-secondary mb-0">On</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card border-1 bg-card rounded-3 p-2">
                                <div class="card-header bg-transparent border-0 ">
                                    <img src="{{ asset('frontend/images/brands/7.png') }}" alt="" class="img-fluid"
                                        style="height: 50px;">
                                </div>
                                <div class="card-body">
                                    <h6 class="text-primary fw-semibold">Resources</h6>
                                    <p class="text-secondary mb-0">On</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card border-1 bg-card rounded-3 p-2">
                                <div class="card-header bg-transparent border-0 ">
                                    <img src="{{ asset('frontend/images/brands/9.png') }}" alt="" class="img-fluid"
                                        style="height: 50px;">
                                </div>
                                <div class="card-body">
                                    <h6 class="text-primary fw-semibold">Journey For Entrepreneurs</h6>
                                    <p class="text-secondary mb-0">On</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>

            <div class="text-center mt-20">
                <h3 class="text-primary" data-aos="fade-up-sm" data-aos-delay="50">
                    Key Offerings
                </h3>
                <h6 class="mt-5" data-aos="fade-up-sm" data-aos-delay="50">
                    How We Support You
                </h6>
            </div>

            <div class="row row-cols-1 row-cols-lg-3 mt-10">
                <div class="col" data-aos="fade-up-sm" data-aos-delay="100">
                    <div class="d-flex flex-column flex-lg-row gap-6">
                        <div
                            class="icon w-14 h-14 flex-shrink-0 d-flex align-center justify-center rounded-3 p-2 border bg-primary bg-opacity-10 text-primary border-primary border-opacity-25">
                            <h4 class="mb-0">01</h4>
                        </div>
                        <div class="content">
                            <h4 class=" mb-4">Mentorship</h4>
                            <p>
                                Receive personalized guidance from experienced entrepreneurs, industry experts, and
                                business leaders.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up-sm" data-aos-delay="150">
                    <div class="d-flex flex-column flex-lg-row gap-6">
                        <div
                            class="icon w-14 h-14 flex-shrink-0 d-flex align-center justify-center rounded-3 p-2 border bg-primary bg-opacity-10 text-primary border-primary border-opacity-25">
                            <h4 class="mb-0">02</h4>
                        </div>
                        <div class="content">
                            <h4 class=" mb-4">Resources</h4>
                            <p>
                                Access cutting-edge tools, co-working spaces, and an extensive library of learning
                                materials designed to help you innovate and grow.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up-sm" data-aos-delay="200">
                    <div class="d-flex flex-column flex-lg-row gap-6">
                        <div
                            class="icon w-14 h-14 flex-shrink-0 d-flex align-center justify-center rounded-3 p-2 border bg-primary bg-opacity-10 text-primary border-primary border-opacity-25">
                            <h4 class="mb-0">03</h4>
                        </div>
                        <div class="content">
                            <h4 class=" mb-4">Funding</h4>
                            <p>
                                Unlock strategic funding opportunities to bring your vision to life, connecting with
                                discerning investors ready to back your ideas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{route('solutions')}}" class="btn btn-primary">Explore Our Program</a>
            </div>
        </div>
    </section>


    <!-- Discover 11B-->
    <section class="mt-20" >
        <div class="container">
            <div class="row align-center">
                <div class="col-lg-6 col-xl-5" data-aos="fade-up-sm" data-aos-delay="50">
                    <p class="text-primary">Discover How 11B Empowers Entrepreneurs and Drives Innovation</p>
                    <div class="text-center text-lg-start position-relative z-1">
                        <h2 class="mb-8" data-aos="fade-up-sm" data-aos-delay="100">
                            Your Partner in Building Bold Ideas and Transforming Communities
                        </h2>
                        <h5 class=" " data-aos="fade-up-sm" data-aos-delay="100">
                            <span class="text-primary">At 11B</span>, we’re more than just a startup
                            accelerator—we’re a movement dedicated to empowering visionary entrepreneurs,
                            fostering innovation, and driving community impact. Our mission is to provide the
                            resources, mentorship,
                            and funding entrepreneurs need to transform groundbreaking ideas into thriving
                            businesses.
                            Rooted in Dearborn, Michigan, we are creating a collaborative ecosystem where ambition
                            meets opportunity and innovation drives sustainable growth.
                        </h5>
                    </div>
                </div>
                <div class="col-lg-6 offset-xl-1" data-aos="fade-up-sm" data-aos-delay="100">
                    <div class="text-center">
                        <img class="img-fluid d-inline-block" src="{{asset('frontend/images/screens/screen-8.png')}}"
                            alt="" />
                    </div>
                </div>
            </div>
            <hr class="border-top border-lite-blue-4 opacity-100" />
        </div>
    </section>


    <section class="mt-20">
        <div class="container">
            <div class="row justify-center mb-10">
                <div class="col-lg-9">
                    <div class="text-center">
                        <h2 class="text-primary mb-0" data-aos="fade-up-sm" data-aos-delay="50">
                            What We Do
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-3 g-6 g-xl-14">
                <div class="col" data-aos="fade-up-sm" data-aos-delay="50">
                    <div class="d-flex flex-column gap-6 flex-lg-row">
                        <div
                            class="icon w-14 h-14 flex-shrink-0 d-flex align-center justify-center rounded-3 p-2 border bg-primary bg-opacity-10 text-primary border-primary border-opacity-25">
                            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 40 40">
                                <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path
                                        d="M30.167 10c-1.833 4.855-3.167 8.188-4 10m0 0c-3.132 6.813-6.188 10-10 10-4 0-8-4-8-10s4-10 8-10c3.778 0 6.892 3.31 10 10Zm0 0c.853 1.837 2.187 5.17 4 10" />
                                </g>
                            </svg>
                        </div>
                        <div class="content">
                            <h4 class=" mb-4">Empowering Visionaries</h4>
                            <p>
                                We provide entrepreneurs with tailored guidance, access to resources, and strategic
                                funding to turn bold ideas into reality.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up-sm" data-aos-delay="100">
                    <div class="d-flex flex-column gap-6 flex-lg-row">
                        <div
                            class="icon w-14 h-14 flex-shrink-0 d-flex align-center justify-center rounded-3 p-2 border bg-primary bg-opacity-10 text-primary border-primary border-opacity-25">
                            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 40 40">
                                <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path d="M3.333 20 20 32.37 36.666 20" />
                                    <path
                                        d="M11.667 15 20 21.667 28.334 15m-10.001-5L20 11.333 21.666 10 20 8.666 18.333 10Z" />
                                </g>
                            </svg>
                        </div>
                        <div class="content">
                            <h4 class=" mb-4">Fostering Collaboration</h4>
                            <p>
                                Our network connects founders with seasoned mentors, discerning investors, and industry
                                experts to build stronger businesses.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up-sm" data-aos-delay="150">
                    <div class="d-flex flex-column gap-6 flex-lg-row">
                        <div
                            class="icon w-14 h-14 flex-shrink-0 d-flex align-center justify-center rounded-3 p-2 border bg-primary bg-opacity-10 text-primary border-primary border-opacity-25">
                            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 40 40">
                                <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path
                                        d="M10 29.334 6.667 27.5v-4.166m0-6.668V12.5L10 10.666m6.667-3.833L20 5l3.334 1.833M30 10.666l3.333 1.834v4.166m0 6.668V27.5L30 29.367m-6.666 3.799L20 35l-3.333-1.834M20 20l3.333-1.834M30 14.333l3.333-1.833M20 20v4.167m0 6.667V35m0-15-3.333-1.867M10 14.333 6.667 12.5" />
                                </g>
                            </svg>
                        </div>
                        <div class="content">
                            <h4 class=" mb-4">Driving Community Impact</h4>
                            <p>
                                By supporting innovative ventures, we create jobs, foster sustainability, and strengthen
                                local economies.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="mt-20">
        <div class="container">
            <div class="bg-lite-blue rounded-4 p-6 p-md-12 px-xl-20 py-xl-12 hover-border">
                <div class="row g-6 g-lg-14 g-xl-20 align-center">
                    <div class="col-lg-6" data-aos="fade-up-sm" data-aos-delay="50">
                        <div class="content">
                            <h2 class="text-primary">Why 11B?</h2>
                            <ul class="list-unstyled list-check mb-8">
                                <h3 class="mb-8">
                                    Our Unique Approach:
                                </h3>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"
                                        class="icon">
                                        <g>
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.5" d="m3.75 9 3.75 3.75 7.5-7.5" />
                                        </g>
                                    </svg>
                                    <span> <strong>Comprehensive Support:</strong> From idea validation to scaling, we
                                        provide end-to-end assistance for entrepreneurs.</span>
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"
                                        class="icon">
                                        <g>
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.5" d="m3.75 9 3.75 3.75 7.5-7.5" />
                                        </g>
                                    </svg>
                                    <span> <strong>Tailored Mentorship:</strong> Our mentors are experts in various
                                        industries, offering personalized advice to help founders navigate
                                        challenges.</span>
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"
                                        class="icon">
                                        <g>
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.5" d="m3.75 9 3.75 3.75 7.5-7.5" />
                                        </g>
                                    </svg>
                                    <span> <strong>Strategic Funding:</strong> We connect startups with discerning
                                        investors who are passionate about fostering innovation.</span>
                                </li>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"
                                        class="icon">
                                        <g>
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.5" d="m3.75 9 3.75 3.75 7.5-7.5" />
                                        </g>
                                    </svg>
                                    <span> <strong>Community-Centric:</strong> At 11B, we prioritize ventures that
                                        create positive, measurable impact in their communities.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up-sm" data-aos-delay="100">
                        <div class="feature-img">
                            <img src="{{asset('frontend/images/illustrations/feature-illustration-3-blue.svg')}}" alt=""
                                class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="features-section has-blurry-shape position-relative mt-20">
        <div class="blurry-shape">
            <img src="{{asset('frontend/images/shapes/blurry-shape-3.svg')}}" alt="" class="img-fluid" />
        </div>
        <div class="container">
            <div class="text-center mb-18 mt-14">
                <h2 class="text-primary mb-0" data-aos="fade-up-sm" data-aos-delay="50">
                    How We Help
                </h2>
                <h5 class=" mb-0 mt-3" data-aos="fade-up-sm" data-aos-delay="50">
                    A Step-by-Step Approach to Success:
                </h5>
            </div>
            <div class="row row-cols-1 row-cols-lg-3 g-6 g-xl-14">
                <div class="col" data-aos="fade-up-sm" data-aos-delay="100">
                    <div class="d-flex flex-column flex-lg-row gap-6">
                        <div
                            class="icon w-14 h-14 flex-shrink-0 d-flex align-center justify-center rounded-3 p-2 border bg-primary bg-opacity-10 text-primary border-primary border-opacity-25">
                            <h4 class="mb-0">01</h4>
                        </div>
                        <div class="content">
                            <h4 class=" mb-4">Apply</h4>
                            <p>
                                Entrepreneurs submit their pitch through our streamlined online application.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up-sm" data-aos-delay="150">
                    <div class="d-flex flex-column flex-lg-row gap-6">
                        <div
                            class="icon w-14 h-14 flex-shrink-0 d-flex align-center justify-center rounded-3 p-2 border bg-primary bg-opacity-10 text-primary border-primary border-opacity-25">
                            <h4 class="mb-0">02</h4>
                        </div>
                        <div class="content">
                            <h4 class=" mb-4">Review and Support</h4>
                            <p>
                                Our team reviews submissions, provides feedback, and offers tailored guidance.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up-sm" data-aos-delay="200">
                    <div class="d-flex flex-column flex-lg-row gap-6">
                        <div
                            class="icon w-14 h-14 flex-shrink-0 d-flex align-center justify-center rounded-3 p-2 border bg-primary bg-opacity-10 text-primary border-primary border-opacity-25">
                            <h4 class="mb-0">03</h4>
                        </div>
                        <div class="content">
                            <h4 class=" mb-4">Fund and Grow</h4>
                            <p>
                                Startups receive strategic funding, mentorship, and resources to scale their ideas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FAQ -->
    <section class="mt-20 mb-20">
        <div class="container">
            <div class="row justify-center mb-18">
                <div class="col-lg-10">
                    <div class="text-center">
                        <h1 class="mb-0 " data-aos="fade-up-sm" data-aos-delay="50">
                            Questions About our GenAI? <br class="d-none d-md-block" />
                            We have Answers!
                        </h1>
                    </div>
                </div>
            </div>

            <div class="row justify-center">
                <div class="col-lg-8" data-aos="fade-up-sm" data-aos-delay="100">
                    <div class="accordion accordion-flush d-flex flex-column gap-6" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapseOne" aria-expanded="false"
                                    aria-controls="faq-collapseOne">
                                    <span class="icon"></span>
                                    What is 11B?
                                </button>
                            </h2>
                            <div id="faq-collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    11B is an innovation hub dedicated to empowering entrepreneurs by providing
                                    mentorship, funding, and resources to help turn groundbreaking ideas into thriving
                                    businesses.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapseTwo" aria-expanded="false"
                                    aria-controls="faq-collapseTwo">
                                    <span class="icon"></span>
                                    Who can apply to 11B’s program?
                                </button>
                            </h2>
                            <div id="faq-collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Entrepreneurs at any stage of their journey—whether early-stage startups or growing
                                    ventures—are welcome to apply as long as they have a scalable and innovative idea.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapseThree" aria-expanded="false"
                                    aria-controls="faq-collapseThree">
                                    <span class="icon"></span>
                                    Does 11B provide funding to startups?
                                </button>
                            </h2>
                            <div id="faq-collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, 11B connects entrepreneurs with strategic funding opportunities, including
                                    investor networks and direct capital, to help startups scale and succeed.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapseFour" aria-expanded="false"
                                    aria-controls="faq-collapseFour">
                                    <span class="icon"></span>
                                    What kind of mentorship does 11B offer?
                                </button>
                            </h2>
                            <div id="faq-collapseFour" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Startups receive tailored guidance from experienced entrepreneurs, industry experts,
                                    and investors to refine their business models, strategies, and growth plans.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapseFive" aria-expanded="false"
                                    aria-controls="faq-collapseFive">
                                    <span class="icon"></span>
                                    How can investors or funders get involved?
                                </button>
                            </h2>
                            <div id="faq-collapseFive" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Funders can support 11B by investing in high-potential startups, participating in
                                    mentorship programs, or joining our network to drive economic growth and innovation.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapseSix" aria-expanded="false"
                                    aria-controls="faq-collapseSix">
                                    <span class="icon"></span>
                                    Is 11B limited to Dearborn-based startups?
                                </button>
                            </h2>
                            <div id="faq-collapseSix" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    While we have a strong focus on the Dearborn, Michigan community, we welcome
                                    innovative entrepreneurs from beyond the region who align with our mission. </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapseSeven" aria-expanded="false"
                                    aria-controls="faq-collapseSeven">
                                    <span class="icon"></span>
                                    How can I learn more about 11B?
                                </button>
                            </h2>
                            <div id="faq-collapseSeven" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    You can explore our programs, meet our team, and discover success stories by
                                    visiting our About Us and Programs pages or contacting us directly. </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main>
@endsection