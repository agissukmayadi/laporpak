@extends('layout.master')

@prepend('styles')
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('storage/template/BizLand') }}/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('storage/template/BizLand') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('storage/template/BizLand') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('storage/template/BizLand') }}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ asset('storage/template/BizLand') }}/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('storage/template/BizLand') }}/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="{{ asset('storage/template/BizLand') }}/assets/vendor/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="{{ asset('storage/template/BizLand') }}/assets/vendor/fontawesome/css/brands.css" rel="stylesheet">
    <link href="{{ asset('storage/template/BizLand') }}/assets/vendor/fontawesome/css/solid.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('storage/template/BizLand') }}/assets/css/style.css" rel="stylesheet">
@endprepend


@section('body')
    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a
                        href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>{{ $contact->phone }}</span></i>
            </div>
        </div>
    </section>

    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="{{ route('home') }}">LaporPak<span>.</span></a></h1>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="{{ route('home') }}#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="{{ route('home') }}#faq">FAQ</a></li>
                    <li><a class="nav-link scrollto" href="{{ route('home') }}#contact">Contact</a></li>
                    <li><a class="nav-link scrollto" href="/api/documentation">API</a></li>
                    <li>
                        <div class=" d-flex align-items-center">
                            @auth
                                <a href="{{ route('dashboard') }}"><button class="btn btn-outline-primary">Dashboard
                                    </button>
                                </a>
                            @endauth

                            @guest
                                <a href="{{ route('login') }}"><button class="btn btn-outline-primary">Login
                                    </button>
                                </a>
                            @endguest
                        </div>
                    </li>
                </ul>

                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->


        </div>
    </header><!-- End Header -->

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>LaporPak<span>.</span></h3>
                        <p>
                            {{ $contact->address }}
                            <br>
                            <strong>Phone:</strong>{{ $contact->phone }}<br>
                            <strong>Email:</strong> {{ $contact->email }}<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#hero">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#faq">FAQ</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#contact">Contact</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="/api/documentation">API</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">

                    </div>
                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>LaporPak</h4>
                        <p>Laporkan kepada kami jika ada penyalahgunaan wewenang, pengabaian kewajiban dan/atau
                            pelanggaran peraturan perundang-undangan</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="container py-4">
            <div class="copyright">
                &copy; Copyright <strong><span>LaporPak</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="#">BizLand</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
@endsection


@prepend('script')
    <!-- Vendor JS Files -->
    <script src="{{ asset('storage/template/BizLand') }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ asset('storage/template/BizLand') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('storage/template/BizLand') }}/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('storage/template/BizLand') }}/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('storage/template/BizLand') }}/assets/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('storage/template/BizLand') }}/assets/vendor/purecounter/purecounter.js"></script>
    <script src="{{ asset('storage/template/BizLand') }}/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('storage/template/BizLand') }}/assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script defer src="{{ asset('storage/template/BizLand') }}/assets/vendor/fontawesome/js/brands.js"></script>
    <script defer src="{{ asset('storage/template/BizLand') }}/assets/vendor/fontawesome/js/solid.js"></script>
    <script defer src="{{ asset('storage/template/BizLand') }}/assets/vendor/fontawesome/js/fontawesome.js"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('storage/template/BizLand') }}/assets/js/main.js"></script>
@endprepend
