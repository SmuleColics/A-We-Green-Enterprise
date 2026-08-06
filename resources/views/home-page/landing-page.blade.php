@extends('layouts.home')

@section('title', 'We Bring The Right Technology')

@section('meta-description', 'Your trusted partner for CCTV, Solar Energy, Solar Street Lighting, and Public Address Systems since 2014.')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home-page/landing-page.css') }}" />
@endsection

@section('content')

    <!-- ============================================================
     NAVBAR
============================================================ -->
    <nav id="main-navbar" class="navbar navbar-expand-lg fixed-top bg-transparent">
        <div class="container">

            <!-- Brand -->
            <a href="#home" class="navbar-brand d-flex align-items-center gap-2 text-decoration-none">
                <span class="brand-icon" id="brand-icon">
                    <img class="hpx-50" src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="">
                </span>
                <span class="brand-text" id="brand-text">
                    <span class="fs-6">A We Green</span>
                    <span class="brand-sub">Enterprise</span>
                </span>
            </a>

            <!-- Mobile toggler -->
            <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-4" id="nav-toggler-icon"></i>
            </button>

            <!-- Nav links -->
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto gap-lg-2 py-3 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#why">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#projects">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact-location">Contact</a></li>
                </ul>
                <div class="d-flex align-items-center flex-column flex-lg-row gap-2 pb-3 pb-lg-0">
                    <a href="{{ route('sign-in') }}" id="sign-in"
                        class="btn btn-outline-light btn-cta btn-sm px-3">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-cta btn-cta-reg btn-sm px-3">Register</a>
                </div>
            </div>

        </div>
    </nav>


    <!-- ============================================================
     HERO
     ============================================================ -->
    <section id="home">
        <img src="{{ asset('css/images/hero-img.jpg') }}"
            alt="Solar panel installation with CCTV security camera at golden hour" class="hero-bg" />
        <div class="hero-overlay"></div>
        <div class="hero-overlay-2"></div>

        <div class="container position-relative z-10">
            <div class="col-lg-8 animate-fade-in-up text-white">

                <!-- Eyebrow badge -->
                <span class="hero-badge mb-4 d-inline-flex">
                    <i class="bi bi-sun text-warning fs-14"></i>
                    Trusted Since 2014
                </span>

                <!-- Headline -->
                <h1 class="font-display fw-bolder mt-3 mb-4 headline-title lh-105"
                >
                    We Bring<br>
                    The <span class="text-accent-c">Right</span><br>
                    Technology
                </h1>

                <!-- Subtitle -->
                <p class="mb-4 fs-18 label-text mw-640 lh-17">
                    Your trusted partner for CCTV, Solar Energy, Solar Street Lighting,
                    and Public Address Systems since 2014.
                </p>

                <!-- CTAs -->
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="{{ route('register') }}" class="btn btn-cta btn-cta-reg px-4 py-2 fs-6">
                        Schedule Free Assessment
                    </a>
                    <a href="#projects" class="btn btn-hero-outline px-4 py-2 fs-6">
                        View Our Projects
                    </a>
                </div>

                <!-- Mini stat cards -->
                <div class="row g-3">
                    <div class="col-6 col-sm-3 w-180">
                        <div class="hero-stat-card">
                            <i class="bi bi-shield-check text-accent-c flex-shrink-0 mt-1 fs-20"></i>
                            <span class="stat-label">5,000+ Cameras Installed</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3 w-180">
                        <div class="hero-stat-card">
                            <i class="bi bi-lightbulb text-accent-c flex-shrink-0 mt-1 fs-20"></i>
                            <span class="stat-label">800+ Solar Street Lights</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3 w-180">
                        <div class="hero-stat-card">
                            <i class="bi bi-award text-accent-c flex-shrink-0 mt-1 fs-20"></i>
                            <span class="stat-label">12 Years of Excellence</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3 w-180">
                        <div class="hero-stat-card">
                            <i class="bi bi-building text-accent-c flex-shrink-0 mt-1 fs-20"></i>
                            <span class="stat-label">Government &amp; Private Trusted</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================================================
     STATS BAR
     ============================================================ -->
    <section id="stats-bar" class="py-4">
        <div class="container py-3">
            <div class="row g-4">

                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-box">
                            <i class="bi bi-calendar-check fs-5 fw-bold"></i>
                        </div>
                        <div>
                            <div class="stat-value">Since 2014</div>
                            <div class="stat-label-text">Years of Service</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-box">
                            <i class="bi bi-check-circle fs-5 fw-bold"></i>
                        </div>
                        <div>
                            <div class="stat-value">5,800+</div>
                            <div class="stat-label-text">Installations Completed</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-box">
                            <i class="bi bi-emoji-smile fs-5"></i>
                        </div>
                        <div>
                            <div class="stat-value">500+</div>
                            <div class="stat-label-text">Satisfied Customers</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-box">
                            <i class="bi bi-geo-alt fs-5"></i>
                        </div>
                        <div>
                            <div class="stat-value">Region IV-A &amp; NCR</div>
                            <div class="stat-label-text">Coverage Areas</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================================================
     SERVICES
     ============================================================ -->
    <section id="services" class="py-5 pad-y-5">
        <div class="container">

            <div class="text-center mb-5 mx-auto mw-720">
                <span class="section-eyebrow">Our Services</span>
                <h2 class="section-title fs-1 mb-3">
                    Comprehensive Solutions for Your Security and Energy Needs
                </h2>
                <p class="section-subtitle">
                    We specialize in four core services designed to protect your property and reduce your energy costs.
                </p>
            </div>

            <div class="row g-4 align-items-stretch">

                <!-- CCTV -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="service-card w-100">
                        <div class="service-icon-box">
                            <i class="bi bi-camera-video fs-4"></i>
                        </div>
                        <h3 class="card-title">CCTV Surveillance</h3>
                        <p class="card-text">
                            HD &amp; IP camera systems with 24/7 monitoring, remote access, and intelligent video
                            analytics for total protection.
                        </p>
                        <ul class="feature-list list-unstyled mb-4">
                            <li><span class="feature-dot"></span> IP &amp; Analog HD</li>
                            <li><span class="feature-dot"></span> Mobile App Access</li>
                            <li><span class="feature-dot"></span> Cloud Recording</li>
                        </ul>
                        <a href="#contact-location" class="learn-more-link">
                            Learn more <i class="bi bi-arrow-right fw-bold"></i>
                        </a>
                    </div>
                </div>

                <!-- Solar Energy -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="service-card w-100">
                        <div class="service-icon-box">
                            <i class="bi bi-sun fs-4"></i>
                        </div>
                        <h3 class="card-title">Solar Energy Systems</h3>
                        <p class="card-text">
                            On-grid, off-grid, and hybrid solar power solutions that cut electric bills and provide
                            reliable clean energy.
                        </p>
                        <ul class="feature-list list-unstyled mb-4">
                            <li><span class="feature-dot"></span> Residential &amp; Commercial</li>
                            <li><span class="feature-dot"></span> Battery Backup</li>
                            <li><span class="feature-dot"></span> Net Metering</li>
                        </ul>
                        <a href="#contact-location" class="learn-more-link">
                            Learn more <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Street Lighting -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="service-card w-100">
                        <div class="service-icon-box">
                            <i class="bi bi-lightbulb fs-4"></i>
                        </div>
                        <h3 class="card-title">Street Lights</h3>
                        <p class="card-text">
                            Strong and bright street lights for roads, subdivisions, parking areas, and barangays.
                        </p>
                        <ul class="feature-list list-unstyled mb-4">
                            <li><span class="feature-dot"></span> Bright LED Light</li>
                            <li><span class="feature-dot"></span> Auto On at Night</li>
                            <li><span class="feature-dot"></span> Rainproof Design</li>
                        </ul>
                        <a href="#contact-location" class="learn-more-link">
                            Learn more <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Public Address -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="service-card w-100">
                        <div class="service-icon-box">
                            <i class="bi bi-megaphone fs-4"></i>
                        </div>
                        <h3 class="card-title">Public Address Systems</h3>
                        <p class="card-text">
                            Outdoor &amp; indoor PA systems for plazas, schools, and LGUs. Wireless and weatherproof
                            options available.
                        </p>
                        <ul class="feature-list list-unstyled mb-4">
                            <li><span class="feature-dot"></span> Wireless Mics</li>
                            <li><span class="feature-dot"></span> Weatherproof</li>
                            <li><span class="feature-dot"></span> Long-Range Coverage</li>
                        </ul>
                        <a href="#contact-location" class="learn-more-link">
                            Learn more <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================================================
     WHY CHOOSE US
     ============================================================ -->
    <section id="why" class="py-5 pad-y-5">
        <div class="container">

            <div class="text-center mb-5 mx-auto mw-720">
                <span class="section-eyebrow">Why Choose Us</span>
                <h2 class="section-title fs-1 mb-3">
                    Built on Trust. Powered by Expertise.
                </h2>
                <p class="section-subtitle">
                    We combine technical excellence with genuine care for our clients and the planet.
                </p>
            </div>

            <div class="row g-4">

                <div class="col-sm-6 col-lg-4">
                    <div class="why-card h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="why-icon-box">
                                <i class="bi bi-award fs-5"></i>
                            </div>
                            <div>
                                <h3>12 Years Experience</h3>
                                <p>Established 2014 with thousands of successful installations across the Calabarzon and
                                    NCR.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="why-card h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="why-icon-box">
                                <i class="bi bi-patch-check-fill fs-5"></i>
                            </div>
                            <div>
                                <h3>PhilGEPS Platinum Registered</h3>
                                <p>Fully accredited for government procurement, qualified to bid on public sector
                                    projects nationwide.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="why-card h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="why-icon-box">
                                <i class="bi bi-tools fs-5"></i>
                            </div>
                            <div>
                                <h3>End-to-End Service</h3>
                                <p>From assessment and design to installation, training, and after-sales support.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="why-card h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="why-icon-box">
                                <i class="bi bi-patch-check fs-5"></i>
                            </div>
                            <div>
                                <h3>Certified Technicians</h3>
                                <p>Licensed, trained, and insured installers on every project — big or small.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="why-card h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="why-icon-box">
                                <i class="bi bi-people fs-5"></i>
                            </div>
                            <div>
                                <h3>Trusted by LGUs</h3>
                                <p>Preferred partner for government, enterprises, schools, and private homes.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="why-card h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="why-icon-box">
                                <i class="bi bi-clock fs-5"></i>
                            </div>
                            <div>
                                <h3>Fast Turnaround</h3>
                                <p>Quick site visits, transparent quotes, and on-schedule project completion.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================================================
     PROCESS / HOW IT WORKS
     ============================================================ -->
    <section class="py-5 pad-y-5">
        <div class="container">

            <div class="text-center mb-5 mx-auto mw-720">
                <span class="section-eyebrow">How It Works</span>
                <h2 class="section-title fs-1">
                    A Simple Path from Inquiry to Installation
                </h2>
            </div>

            <div class="row g-4 process-track">

                <!-- Step 1 -->
                <div class="col-12 col-md-3 text-center process-step">
                    <div class="process-icon-wrap">
                        <i class="bi bi-clipboard-check fs-4"></i>
                        <span class="step-number-badge">1</span>
                    </div>
                    <p class="step-label">Step 1</p>
                    <h3 class="step-title">Free Assessment</h3>
                    <p class="step-text">We visit your site, listen to your needs, and assess the technical
                        requirements.</p>
                </div>

                <!-- Step 2 -->
                <div class="col-12 col-md-3 text-center process-step">
                    <div class="process-icon-wrap">
                        <i class="bi bi-pencil-square fs-4"></i>
                        <span class="step-number-badge">2</span>
                    </div>
                    <p class="step-label">Step 2</p>
                    <h3 class="step-title">Custom Design &amp; Quote</h3>
                    <p class="step-text">Our team makes a solution that fits your needs and gives you a clear, detailed
                        quote.</p>
                </div>

                <!-- Step 3 -->
                <div class="col-12 col-md-3 text-center process-step">
                    <div class="process-icon-wrap">
                        <i class="bi bi-hammer fs-4"></i>
                        <span class="step-number-badge">3</span>
                    </div>
                    <p class="step-label">Step 3</p>
                    <h3 class="step-title">Professional Installation</h3>
                    <p class="step-text">Certified technicians install with care, on schedule and built to last.</p>
                </div>

                <!-- Step 4 -->
                <div class="col-12 col-md-3 text-center process-step">
                    <div class="process-icon-wrap">
                        <i class="bi bi-headset fs-4"></i>
                        <span class="step-number-badge">4</span>
                    </div>
                    <p class="step-label">Step 4</p>
                    <h3 class="step-title">After-Sales Support</h3>
                    <p class="step-text">Our team remains available for maintenance, troubleshooting, and follow-up
                        visits to keep your system running smoothly.</p>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================================================
     PROJECTS
     ============================================================ -->
    <section id="projects" class="py-5 pad-y-5">
        <div class="container">

            <div class="text-center mb-5 mx-auto mw-720">
                <span class="section-eyebrow text-acc-color">Featured Projects</span>
                <h2 class="fw-bold fs-1 text-white font-display mb-3">See Our Work in Action</h2>
                <p class="projects-text fs-17">
                    Real installations across Luzon — securing communities and powering progress.
                </p>
            </div>

            <div class="row g-4">

                <!-- CCTV -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <article class="project-card w-100">
                        <div class="img-wrap">
                            <img src="{{ asset('css/images/cctv.jpg') }}"
                                alt="Citywide CCTV Network — Metro Manila LGU" loading="lazy" />
                        </div>
                        <div class="card-body">
                            <span class="project-tag">Security</span>
                            <h3>Citywide CCTV Network</h3>
                            <p class="project-loc"><i class="bi bi-geo-alt-fill me-1"></i>Metro Manila LGU</p>
                            <p class="project-desc">Installed a full HD IP camera network across barangay roads and
                                public areas for 24/7 surveillance coverage.</p>
                            <div class="project-meta">
                                <span><i class="bi bi-camera-video me-1"></i>32 Cameras</span>
                                <span><i class="bi bi-check-circle me-1"></i>Completed</span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Solar -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <article class="project-card w-100">
                        <div class="img-wrap">
                            <img src="{{ asset('css/images/solar-setup.jpg') }}"
                                alt="Commercial Solar Array — Manufacturing Facility, Cavite" loading="lazy" />
                        </div>
                        <div class="card-body">
                            <span class="project-tag">Solar Energy</span>
                            <h3>Commercial Solar Array</h3>
                            <p class="project-loc"><i class="bi bi-geo-alt-fill me-1"></i>Manufacturing Facility,
                                Cavite</p>
                            <p class="project-desc">Rooftop grid-tied solar system reducing facility energy costs by up
                                to 60% with net metering integration.</p>
                            <div class="project-meta">
                                <span><i class="bi bi-sun me-1"></i>20 Panels</span>
                                <span><i class="bi bi-check-circle me-1"></i>Completed</span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Street Light -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <article class="project-card w-100">
                        <div class="img-wrap">
                            <img class="img-wrap-src" src="{{ asset('css/images/street-light.jpg') }}"
                                alt="Solar Street Lighting — Provincial Highway, Luzon" loading="lazy"
                                />
                        </div>
                        <div class="card-body">
                            <span class="project-tag">Public Works</span>
                            <h3>Solar Street Lighting</h3>
                            <p class="project-loc"><i class="bi bi-geo-alt-fill me-1"></i>Provincial Highway, Luzon
                            </p>
                            <p class="project-desc">Deployed all-in-one solar street lights along a 2km provincial
                                road, improving safety for residents at night.</p>
                            <div class="project-meta">
                                <span><i class="bi bi-lightbulb me-1"></i>40 Units</span>
                                <span><i class="bi bi-check-circle me-1"></i>Completed</span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Public Address -->
                <div class="col-sm-6 col-lg-3 d-flex">
                    <article class="project-card w-100">
                        <div class="img-wrap">
                            <img src="{{ asset('css/images/public-address.jpg') }}"
                                alt="Public Address System — Municipal Plaza, Batangas" loading="lazy" />
                        </div>
                        <div class="card-body">
                            <span class="project-tag">Public Address</span>
                            <h3>Public Address System</h3>
                            <p class="project-loc"><i class="bi bi-geo-alt-fill me-1"></i>Municipal Plaza, Batangas
                            </p>
                            <p class="project-desc">Weatherproof PA system with wireless microphone capability
                                installed for announcements and emergency alerts.</p>
                            <div class="project-meta">
                                <span><i class="bi bi-megaphone me-1"></i>8 Speakers</span>
                                <span><i class="bi bi-check-circle me-1"></i>Completed</span>
                            </div>
                        </div>
                    </article>
                </div>

            </div>

            <div class="text-center mt-5">
                <a href="{{ route('register') }}" class="btn btn-outline-light px-4 py-2 fw-semibold borr-10">
                    See More <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

        </div>
    </section>


    <!-- ============================================================
     TESTIMONIALS
     ============================================================ -->
    <section id="testimonials" class="py-5 pad-y-5">
        <div class="container">

            <div class="text-center mb-5 mx-auto mw-720">
                <span class="section-eyebrow">Testimonials</span>
                <h2 class="section-title fs-1">What Our Clients Say</h2>
            </div>

            <div class="row g-4">

                <div class="col-md-4 d-flex">
                    <div class="testimonial-card w-100">
                        <i class="bi bi-quote quote-icon fs-40"></i>
                        <div class="star-row">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <blockquote>
                            "A We Green installed CCTV across our entire facility. Quality of work is excellent and
                            after-sales support is top-notch."
                        </blockquote>
                        <div class="border-top pt-3">
                            <div class="reviewer-name">Engr. Roberto Cruz</div>
                            <div class="reviewer-role">Operations Manager, Manufacturing Plant</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 d-flex">
                    <div class="testimonial-card w-100">
                        <i class="bi bi-quote quote-icon fs-40"></i>
                        <div class="star-row">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <blockquote>
                            "Our solar street lights have been running flawlessly for 3 years. Best decision our
                            barangay ever made."
                        </blockquote>
                        <div class="border-top pt-3">
                            <div class="reviewer-name">Hon. Maria Santos</div>
                            <div class="reviewer-role">Barangay Captain, Bulacan</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 d-flex">
                    <div class="testimonial-card w-100">
                        <i class="bi bi-quote quote-icon fs-40"></i>
                        <div class="star-row">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <blockquote>
                            "Professional team, fair pricing, and they actually deliver on time. Highly recommend their
                            solar systems."
                        </blockquote>
                        <div class="border-top pt-3">
                            <div class="reviewer-name">Anna Reyes</div>
                            <div class="reviewer-role">Homeowner, Quezon City</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================================================
     OFFICE LOCATION
     ============================================================ -->
    <section id="contact-location" class="py-5 pad-y-5">
        <div class="container">

            <div class="d-flex flex-column flex-lg-row align-items-lg-end justify-content-lg-between gap-4 mb-5">
                <div class="mw-600">
                    <span class="section-eyebrow">
                        <span class="eyebrow-line"></span> Find Us
                    </span>
                    <h2 class="section-title mb-2 ofl-title">
                        Our <span class="text-primary-c">Office Location</span>
                    </h2>
                    <div class="accent-bar"></div>
                    <p class="section-subtitle mt-3">
                        Strategically based in Gen. Mariano Alvarez, Cavite — well-positioned to serve
                        communities and projects across Region IV-A and Metro Manila.
                    </p>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query=Alta+Tierra+Homes+Phase+4+Blk+51+Lot+30+Brgy+A+Olaes+Gen+Mariano+Alvarez+Cavite+4117"
                    target="_blank" rel="noopener noreferrer"
                    class="btn btn-outline-secondary px-4 py-2 fw-semibold flex-shrink-0 align-self-start align-self-lg-end borr-10">
                    Open in Google Maps <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
            </div>

            <div class="row g-4">

                <div class="col-lg-8">
                    <div class="map-wrapper">
                        <iframe class="d-block border-0" title="A We Green Enterprise office location"
                            src="https://www.google.com/maps?q=Alta+Tierra+Homes+Phase+4+Blk+51+Lot+30+Brgy+A+Olaes+Gen+Mariano+Alvarez+Cavite+4117&output=embed"
                            width="100%" height="480" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            >
                        </iframe>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="location-card">

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="location-icon-box">
                                <i class="bi bi-geo-alt-fill fs-5"></i>
                            </div>

                            <div class="d-flex flex-column justify-content-center">
                                <h3 class="mb-0 lh-1">A We Green</h3>
                                <span class="lh-1 mt-1">Enterprise</span>
                            </div>
                        </div>

                        <p class="info-label mb-1">Main Office</p>
                        <address class="mb-2">
                            Alta Tierra Homes Phase 4, Blk 51 Lot 30<br>
                            Brgy. A. Olaes, Gen. Mariano Alvarez,<br>
                            Cavite 4117
                        </address>

                        <p class="info-label mb-1">Satellite Office</p>
                        <address class="mb-0">
                            Alta Tierra Homes Phase 5, Blk 14 Lot 5<br>
                            Brgy. A. Olaes, Gen. Mariano Alvarez,<br>
                            Cavite 4117
                        </address>

                        <hr class="mt-3 my-4">

                        <div class="d-flex flex-column gap-3">

                            <div class="info-row">
                                <i class="bi bi-clock info-row-icon fs-16"></i>
                                <div>
                                    <p class="info-label mb-1">Operating Hours</p>
                                    <p class="info-value mb-0">Mon – Sat, 8:00 AM – 5:00 PM</p>
                                </div>
                            </div>

                            <div class="info-row">
                                <i class="bi bi-telephone info-row-icon fs-16"></i>
                                <div>
                                    <p class="info-label mb-1">Phone</p>
                                    <p class="info-value mb-0">
                                        <a href="tel:+639998845671">Smart: 0998 884 5671</a> <br>
                                        <a href="tel:+639177523343">Globe: 0917 752 3343</a> <br>
                                        <a href="tel:+63464436374">Landline: 046 443 6374</a>
                                    </p>
                                </div>
                            </div>

                            <div class="info-row">
                                <i class="bi bi-envelope info-row-icon fs-16"></i>
                                <div>
                                    <p class="info-label mb-1">Email</p>
                                    <p class="info-value mb-0">
                                        <a href="mailto:awegreenenterprise@gmail.com">awegreenenterprise@gmail.com</a>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================================================
     CTA BANNER
     ============================================================ -->
    <section id="cta-banner" class="py-5 pad-y-5">
        <div class="container cta-inner text-center text-white">

            <h2 class="fw-bolder mx-auto mb-4 mw-720 lh-12 section-title">
                Ready to Secure and Power Your Property?
            </h2>
            <p class="mb-4 mx-auto mw-600 fs-17 label-text">
                Schedule your free site assessment today. Our team will check your location and recommend the best
                solution for your needs.
            </p>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="tel:+639998845671" class="btn btn-gold-lg btn-light">
                    <span class="btn-main">
                        <i class="bi bi-telephone-fill"></i> Call us now
                    </span>
                    <span class="btn-sub">0998 884 5671</span>
                </a>
                <a href="{{ route('sign-in') }}" class="btn-outline-lg">
                    <span class="btn-main">
                        <i class="bi bi-calendar-check-fill"></i> Schedule an Assessment
                    </span>
                    <span class="btn-sub">Free site visit, no obligations</span>
                </a>
            </div>

            <p class="cta-footnote">
                Free consultation &bull; Transparent pricing &bull; No hidden fees
            </p>

        </div>
    </section>


    <!-- ============================================================
     FOOTER
     ============================================================ -->
    <footer>
        <div class="container py-5">
            <div class="row g-5">

                <div class="col-md-6 col-lg-3">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <div class="footer-brand-icon bg-transparent">
                            <img class="hpx-40" src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="">
                        </div>
                        <div>
                            <div class="footer-brand-name">A We Green</div>
                            <div class="footer-brand-sub">Enterprise</div>
                        </div>
                    </div>
                    <p class="footer-desc">
                        We bring the right technology to communities — through CCTV, solar, and public address solutions
                        since 2014.
                    </p>
                    <div class="d-flex gap-2 mt-4">
                        <a href="#" aria-label="Facebook" class="footer-social-link">
                            <i class="bi bi-facebook fs-16"></i>
                        </a>
                        <a href="#" aria-label="Instagram" class="footer-social-link">
                            <i class="bi bi-instagram fs-16"></i>
                        </a>
                        <a href="#" aria-label="X" class="footer-social-link fs-16">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-lg-2 offset-lg-1">
                    <h4>Services</h4>
                    <ul class="footer-links">
                        <li><a href="#services">CCTV Surveillance</a></li>
                        <li><a href="#services">Solar Energy Systems</a></li>
                        <li><a href="#services">Solar Street Lighting</a></li>
                        <li><a href="#services">Public Address Systems</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h4>Company</h4>
                    <ul class="footer-links">
                        <li><a href="#why">About Us</a></li>
                        <li><a href="#projects">Our Projects</a></li>
                        <li><a href="#contact-location">Schedule Assessment</a></li>
                        <li><a href="#contact-location">Contact</a></li>
                    </ul>
                </div>

                <div class="col-md-6 col-lg-3">
                    <h4>Get in Touch</h4>
                    <div class="d-flex flex-column gap-1">
                        <div class="footer-contact-item">
                            <i class="bi bi-telephone fs-16"></i>
                            <div>
                                <a href="tel:+639998845671">Smart: 0998 884 5671</a><br>
                                <a href="tel:+639177523343">Globe: 0917 752 3343</a><br>
                                <a href="tel:+63464436374">Landline: (046) 443 6374</a>
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <i class="bi bi-envelope fs-16"></i>
                            <a href="mailto:awegreenenterprise@gmail.com">awegreenenterprise@gmail.com</a>
                        </div>
                        <div class="footer-contact-item">
                            <i class="bi bi-geo-alt fs-16"></i>
                            <span>Gen. Mariano Alvarez, Cavite<br />Serving Region IV-A & NCR</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer-bottom">
            <div
                class="container py-3 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <p class="mb-0">© <span id="footer-year"></span> A We Green Enterprise. All rights reserved.</p>
                <p class="mb-0">We bring the right technology to communities since 2014.</p>
            </div>
        </div>
    </footer>

@endsection

@section('scripts')
    <script>
        /* ---- Footer year ---- */
        document.getElementById('footer-year').textContent = new Date().getFullYear();

        /* ---- Navbar scroll behavior ---- */
        const navbar = document.getElementById('main-navbar');
        const brandIcon = document.getElementById('brand-icon');
        const brandText = document.getElementById('brand-text');
        const signIn = document.getElementById('sign-in');
        const navTogglerIcon = document.getElementById('nav-toggler-icon');
        const navMenu = document.getElementById('navMenu');

        function isMenuOpen() {
            return navMenu.classList.contains('show');
        }

        function handleScroll() {
            const scrolled = window.scrollY > 30 || isMenuOpen();
            navbar.classList.toggle('scrolled', scrolled);

            if (scrolled) {
                brandIcon.classList.replace('brand-icon-transparent', 'brand-icon-solid');
                brandText.style.color = '#1f2937';
                signIn.style.color = '#1f2937';
                navTogglerIcon.style.color = '#1f2937';
            } else {
                brandIcon.classList.replace('brand-icon-solid', 'brand-icon-transparent');
                brandText.style.color = '#fff';
                signIn.style.color = '#fff';
                navTogglerIcon.style.color = '#fff';
            }
        }
 
        window.addEventListener('scroll', handleScroll);
        handleScroll();

        /* ---- Scroll-spy: highlight the nav link for the section in view ---- */
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('#main-navbar .nav-link');

        function updateActiveLink() {
            const scrollPos = window.scrollY + 120; // offset so it flips slightly before the section top hits the very edge

            let currentId = sections[0]?.id;
            sections.forEach(section => {
                if (scrollPos >= section.offsetTop) {
                    currentId = section.id;
                }
            });

            navLinks.forEach(link => {
                const isActive = link.getAttribute('href') === `#${currentId}`;
                link.classList.toggle('active', isActive);
            });
        }

        window.addEventListener('scroll', updateActiveLink);
        updateActiveLink();

        /* ---- Re-apply correct scroll-based colors the moment
           the mobile menu closes, in case scroll state changed
           while it was open ---- */
        navMenu.addEventListener('hidden.bs.collapse', handleScroll);
        navMenu.addEventListener('shown.bs.collapse', handleScroll);

        /* ---- Smooth scroll for anchor links ---- */
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    if (isMenuOpen()) {
                        bootstrap.Collapse.getInstance(navMenu)?.hide();
                    }
                }
            });
        });
    </script>
@endsection