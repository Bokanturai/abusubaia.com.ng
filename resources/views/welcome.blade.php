<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Digital Verify Sub - {{ $title ?? 'Welcome Sir All our services is going smothly' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Open Graph / WhatsApp Meta Tags -->
    <meta property="og:title" content="Digital Verify Sub - Innovative Digital Solutions">
    <meta property="og:description"
        content="Empowering northern Nigeria through innovative digital solutions and smart technology services.">
    <meta property="og:image" content="{{ asset('assets/img/logo/logo.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
</head>

<body class="bg-white">
    <div id="global-loader" style="display: none;">
        <div class="page-loader"></div>
    </div>

    <!-- Header -->
    <header>
        <div class="container-fluid header-container px-0 px-md-3">
            <a href="#" class="logo">
                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Digital Verify Sub"
                    style="height: 50px; margin-right: 10px;">
            </a>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#partners">Partners</a></li>
                    <li><a href="#support">Support</a></li>
                    <li><a href="#about-us">About Us</a></li>
                    <li><a href="{{route('login')}}" class="btn btn-primary text-white">Get Started</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero position-relative overflow-hidden" id="home"
        style="background: linear-gradient(rgba(0, 8, 36, 0.85), rgba(0, 47, 186, 0.7)), url('{{ asset('assets/images/logo/hero.png') }}') no-repeat center center/cover; min-height: 100vh; display: flex; align-items: center;">
        
        <!-- Animated Background Elements -->
        <div style="position: absolute; top: -10%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(77,107,224,0.4) 0%, transparent 70%); border-radius: 50%; filter: blur(60px); animation: pulse-green 6s infinite alternate;"></div>
        <div style="position: absolute; bottom: -10%; right: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(0,47,186,0.5) 0%, transparent 70%); border-radius: 50%; filter: blur(80px); animation: pulse-green 8s infinite alternate-reverse;"></div>

        <div class="container hero-content-wrapper position-relative z-3 mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <span class="badge rounded-pill bg-white text-primary mb-4 px-4 py-2 shadow-sm" data-aos="fade-down" style="font-size: 0.95rem; font-weight: 600; letter-spacing: 1px; color: #002fba !important;">
                        <i class="fas fa-rocket me-2" style="color: #002fba;"></i> Elevate Your Business Today
                    </span>
                    <h1 class="display-3 fw-bold mb-4 text-white" data-aos="fade-up" data-aos-delay="100" style="line-height: 1.2;">
                        Modern Agency & <br/><span style="color: #6da2ff; text-shadow: 0 0 20px rgba(109,162,255,0.4);">Verification</span> Services
                    </h1>
                    <p class="lead mb-5 mx-auto" data-aos="fade-up" data-aos-delay="200" style="max-width: 750px; color: rgba(255,255,255,0.9); font-size: 1.25rem;">
                        Experience premium, reliable, and innovative digital solutions tailored for your growth. Fast-track your verification needs with our secure platform.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{route('register')}}" class="btn btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg text-white" style="background: linear-gradient(135deg, #002fba, #4d6be0); border: none; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(0,47,186,0.5)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 .5rem 1rem rgba(0,0,0,.15)';">
                            Get Started Now <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="{{route('login')}}" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 fw-bold" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.5); transition: background 0.3s, color 0.3s;" onmouseover="this.style.background='#fff'; this.style.color='#002fba';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.color='#fff';">
                            Login Now
                        </a>
                    </div>
                    
                    <!-- Trust indicators -->
                    <div class="mt-5 pt-4 border-top border-light border-opacity-25" data-aos="fade-up" data-aos-delay="400">
                        <p class="text-white-50 text-uppercase mb-3 fw-bold" style="font-size: 0.85rem; letter-spacing: 2px;">Trusted by 5,000+ Businesses</p>
                        <div class="d-flex justify-content-center gap-4 opacity-75">
                            <i class="fas fa-shield-alt fa-2x text-white"></i>
                            <i class="fas fa-lock fa-2x text-white"></i>
                            <i class="fas fa-check-circle fa-2x text-white"></i>
                            <i class="fas fa-globe fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    @include('pages.landing.services')

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials-section position-relative"
        style="padding: 100px 0; background: #f8fafc; overflow: hidden;">
        <!-- Modern Grid Pattern Background -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.4; background-image: radial-gradient(#002fba 1px, transparent 1px); background-size: 30px 30px;"></div>

        <div class="container px-0 px-md-3 position-relative z-3">
            <div class="section-title text-center mb-5" data-aos="fade-up">
                <span class="badge bg-primary bg-opacity-10 px-4 py-2 rounded-pill mb-3 fw-bold" style="letter-spacing: 2px; color: #002fba; font-size: 0.85rem;">CLIENT SUCCESS STORIES</span>
                <h2 style="color: #0f172a; font-weight: 800; font-size: 2.8rem; margin-top: 10px;">Trusted by Industry Leaders</h2>
                <hr style="width: 80px; height: 4px; background: #002fba; margin: 20px auto; border: none; border-radius: 2px;">
                <p class="text-muted" style="max-width: 650px; margin: 0 auto; font-size: 1.15rem;">
                    See what our partners and clients have to say about their experience working with Digital Verify Sub.
                </p>
            </div>

            <div class="row g-4 mt-2">
                <!-- Testimonial 1 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="modern-testimonial-card h-100 p-4 p-md-5 bg-white rounded-4 shadow-sm position-relative border-0" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                        <div class="position-absolute top-0 end-0 p-4" style="opacity: 0.05;">
                            <i class="fas fa-quote-right fa-4x" style="color: #002fba;"></i>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('assets/images/avatar/avatar-8.jpg') }}" alt="Abdulrahman Musa" class="rounded-circle shadow-sm" style="width: 65px; height: 65px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0 fw-bold" style="color: #0f172a; font-size: 1.1rem;">Abdulrahman Musa</h5>
                                <span class="small fw-semibold" style="color: #002fba;">CEO, NorthernTech</span>
                            </div>
                        </div>
                        <p class="fst-italic mb-0" style="line-height: 1.8; font-size: 1.05rem; color: #475569;">
                            "Digital Verify Sub transformed our operations with cutting-edge solutions. Their support team is always responsive and professional! Truly a game changer for our business."
                        </p>
                        <div class="mt-4 pt-3 border-top border-light">
                            <div class="d-flex fs-6" style="color: #ffd700;">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="modern-testimonial-card h-100 p-4 p-md-5 bg-white rounded-4 shadow-sm position-relative border-0" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                        <div class="position-absolute top-0 end-0 p-4" style="opacity: 0.05;">
                            <i class="fas fa-quote-right fa-4x" style="color: #002fba;"></i>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('assets/images/avatar/avatar-3.jpg') }}" alt="Fatima Bello" class="rounded-circle shadow-sm" style="width: 65px; height: 65px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0 fw-bold" style="color: #0f172a; font-size: 1.1rem;">Fatima Bello</h5>
                                <span class="small fw-semibold" style="color: #002fba;">Manager, Logistics</span>
                            </div>
                        </div>
                        <p class="fst-italic mb-0" style="line-height: 1.8; font-size: 1.05rem; color: #475569;">
                            "Working with Digital Verify Sub has been a seamless experience. Their expertise and attention to detail are unmatched. They delivered exactly what we needed, on time."
                        </p>
                        <div class="mt-4 pt-3 border-top border-light">
                            <div class="d-flex fs-6" style="color: #ffd700;">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 - Highlighted -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="modern-testimonial-card h-100 p-4 p-md-5 text-white rounded-4 shadow-lg position-relative border-0 overflow-hidden" style="background: linear-gradient(135deg, #002fba 0%, #001f7a 100%); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0, 47, 186, 0.3)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 1rem 3rem rgba(0,0,0,.175)';">
                        <div class="position-absolute top-0 end-0 p-4" style="opacity: 0.15;">
                            <i class="fas fa-quote-right fa-4x text-white"></i>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 h-50" style="background: linear-gradient(transparent, rgba(0,0,0,0.2)); z-index: 1;"></div>
                        
                        <div class="position-relative z-2">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" alt="Emeka Johnson" class="rounded-circle shadow-sm" style="width: 65px; height: 65px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3);">
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0 fw-bold text-white" style="font-size: 1.1rem;">Emeka Johnson</h5>
                                    <span class="small fw-semibold" style="color: #8bb0ff;">IT Director</span>
                                </div>
                            </div>
                            <p class="fst-italic mb-0" style="line-height: 1.8; font-size: 1.05rem; color: rgba(255,255,255,0.9);">
                                "The quality of service and support we've received from Digital Verify Sub is outstanding. Highly recommended for any business looking to scale digitally."
                            </p>
                            <div class="mt-4 pt-3 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
                                <div class="d-flex fs-6" style="color: #ffd700;">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('pages.landing.support')

    <!-- Footer -->
    <footer>
        <!-- Background Decoration -->
        <div
            style="position: absolute; top: 0; right: 0; width: 400px; height: 400px; background: radial-gradient(circle, rgba(0, 47, 186, 0.1) 0%, rgba(0,0,0,0) 70%);">
        </div>

        <div class="container px-0 px-md-3" style="position: relative; z-index: 2;">
            <div class="row g-5">
                <!-- Company Info -->
                <div class="col-lg-4 col-md-6">
                    <h2 style="color: #002fba; font-weight: 800; margin-bottom: 25px; font-size: 2rem;">Digital Verify Sub
                    </h2>
                    <p style="color: rgba(255,255,255,0.7); line-height: 1.8; margin-bottom: 30px;">
                        Providing innovative technology solutions to help businesses thrive in the digital world. We are
                        committed to excellence and sustainable growth in Northern Nigeria.
                    </p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/katsinanews?mibextid=ZbWKwL" class="footer-social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="footer-social"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="footer-social"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.tiktok.com/@safana?_r=1&_t=ZS-93SEZ246vAm" class="footer-social"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h3
                        style="color: #fff; font-size: 1.2rem; font-weight: 700; margin-bottom: 25px; display: inline-block;">
                        DIGITAL VERIFY SUB</h3>
                    <div style="width: 40px; height: 3px; background: #002fba; margin-bottom: 20px;"></div>
                    <ul class="footer-links list-unstyled">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#partners">Partners</a></li>
                        <li><a href="#support">Support</a></li>
                        <li><a href="#about-us">About Us</a></li>
                        <li><a href="javascript:void(0)" onclick="openDataProtectionModal()">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-lg-3 col-md-6">
                    <h3
                        style="color: #fff; font-size: 1.2rem; font-weight: 700; margin-bottom: 25px; display: inline-block;">
                        Our Services</h3>
                    <div style="width: 40px; height: 3px; background: #002fba; margin-bottom: 20px;"></div>
                    <ul class="footer-links list-unstyled">
                        <li><a href="#services">NIN Services</a></li>
                        <li><a href="#services">BVN Services</a></li>
                        <li><a href="#services">Identity Verification</a></li>
                        <li><a href="#services">Utility Payments</a></li>
                        <li><a href="#services">Data & Airtime</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6">
                    <h3
                        style="color: #fff; font-size: 1.2rem; font-weight: 700; margin-bottom: 25px; display: inline-block;">
                        Contact Us</h3>
                    <div style="width: 40px; height: 3px; background: #002fba; margin-bottom: 20px;"></div>
                    <ul class="footer-contact list-unstyled">
                        <li style="margin-bottom: 20px; display: flex;">
                            <div style="width: 30px; color: #002fba; margin-top: 2px;"><i
                                    class="fas fa-map-marker-alt"></i></div>
                            <span style="color: rgba(255,255,255,0.8);">Tudun Wada Street, Gwammaja, Kano</span>
                        </li>
                        <li style="margin-bottom: 20px; display: flex;">
                            <div style="width: 30px; color: #002fba; margin-top: 2px;"><i class="fas fa-phone"></i>
                            </div>
                            <span style="color: rgba(255,255,255,0.8);">09112345678</span>
                        </li>
                        <li style="margin-bottom: 20px; display: flex;">
                            <div style="width: 30px; color: #002fba; margin-top: 2px;"><i class="fas fa-envelope"></i>
                            </div>
                            <span style="color: rgba(255,255,255,0.8);">safanane@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.1); margin: 60px 0 30px;">

            <div class="footer-bottom text-center">
                <p style="color: rgba(255,255,255,0.6); margin: 0;">&copy; {{ date('Y') }} Digital Verify Sub. All rights
                    reserved. | Designed with <i class="fas fa-heart" style="color: #002fba;"></i> by Digital Verify Sub Team.
                </p>
            </div>
        </div>
    </footer>

    <!-- Privacy Banner (Footer) -->
    <div class="privacy-banner rounded-0 rounded-md-4" id="privacyBanner">
        <div class="banner-content">
            <div class="d-flex align-items-center mb-3 mb-md-0">
                <i class="fas fa-shield-alt privacy-icon"></i>
                <div class="privacy-text">
                    <h5>Your Privacy Matters</h5>
                    <p>We value your privacy and are committed to protecting your personal data in compliance with the
                        Data Protection Regulation (NDPR). We collect data to provide verification services.</p>
                </div>
            </div>
            <div class="banner-actions">
                <a href="javascript:void(0)" class="link-primary" onclick="openDataProtectionModal()">Read Full
                    Policy</a>
                <button type="button" class="btn btn-outline-secondary" onclick="rejectPrivacy()">Reject</button>
                <button type="button" class="btn btn-primary" onclick="acceptPrivacyPolicy()">Accept & Continue</button>
            </div>
        </div>
    </div>

    <!-- Data Protection Modal -->
    <div class="modal fade data-protection-modal" id="dataProtectionModal" tabindex="-1"
        aria-labelledby="dataProtectionModalLabel" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataProtectionModalLabel"><i class="fas fa-shield-alt me-2"></i> Data
                        Protection & Privacy Policy</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo" style="height: 60px;">
                        <h4 class="mt-3 text-dark">Digital Verify Sub Data Privacy Commitment</h4>
                    </div>

                    <p class="lead text-center mb-4" style="font-size: 1.1rem; color: #555;">
                        At Digital Verify Sub, we are committed to protecting your personal data in compliance with the
                        <strong>Nigeria Data Protection Regulation (NDPR) 2019</strong>.
                    </p>

                    <div class="policy-section">
                        <h5>1. Introduction</h5>
                        <p>This Privacy Policy explains how Digital Verify Sub collects, uses, and protects your personal
                            information when you use our digital solutions, including our website, mobile applications,
                            and NIN/BVN services.</p>
                    </div>

                    <div class="policy-section">
                        <h5>2. Data Collection</h5>
                        <p>We collect information you provide directly to us, such as when you create an account,
                            request services, or contact customer support.</p>
                    </div>

                    <div class="alert alert-warning mt-4 text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        By clicking "I Agree & Continue", you acknowledge that you have read and understood this Privacy
                        Policy and agree to our Terms of Service.
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('register') }}" class="btn btn-primary px-5 py-2 fw-bold"
                        onclick="acceptPrivacyPolicy()">
                        I Agree & Continue <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/2347036826500" class="whatsapp-float" target="_blank" title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <script src="{{ asset('assets/js/landing.js') }}"></script>
</body>

</html>
