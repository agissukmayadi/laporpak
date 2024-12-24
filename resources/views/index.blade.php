@extends('layout.index')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
@endpush

@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
            <h1>Welcome to <span>LaporPak</span></h1>
            <h5>{{ $about->description }}</h5>
            <div class="d-flex">
                @guest
                    <a href="{{ route('login') }}" class="btn-get-started">Get Started</a>
                @endguest

                @auth
                    <a href="{{ route('dashboard') }}" class="btn-get-started">Get Started</a>
                @endauth
            </div>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Featured Services Section ======= -->
        <section id="featured-services" class="featured-services">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h3>ALUR PENGADUAN <span>MASYARAKAT</span></h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon">
                                <span style="font-size: 3rem;">
                                    <span style="color: #106EEA;">
                                        <i class="fas fa-inbox"></i>
                                    </span>
                                </span>
                            </div>
                            <h4 class="title">Input Laporan</h4>
                            <p class="description">Laporan pengaduan melalui LaporPak</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon">
                                <span style="font-size: 3rem;">
                                    <span style="color: #106EEA;">
                                        <i class="fas fa-user-check"></i>
                                    </span>
                                </span>
                            </div>
                            <h4 class="title">Verifikasi Laporan</h4>
                            <p class="description">Verifikasi laporan yang relevan dan jelas oleh Tim LaporPak</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon"><span style="font-size: 3rem;">
                                    <span style="color: #106EEA;">
                                        <i class="fas fa-poll-h"></i>
                                    </span>
                                </span></div>
                            <h4 class="title">Tindak Lanjut Laporan</h4>
                            <p class="description">Menindak lanjuti laporan yang telah di laporkan oleh masyarakat oleh
                                Pemerintah Daerah</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon">
                                <span style="font-size: 3rem;">
                                    <span style="color: #106EEA;">
                                        <i class="fas fa-chart-line"></i>
                                    </span>
                                </span>
                            </div>
                            <h4 class="title">Pantau Perkembangan</h4>
                            <p class="description">Ikuti terus perkembangan laporan dengan pemerintah
                                setempat</p>
                        </div>
                    </div>
                </div>
            </div>


        </section><!-- End Featured Services Section -->

        @if ((Auth::check() && Auth::user()->role == 'Citizen') || !Auth::check())
            <section id="laporan">
                <div class="container" data-aos="fade-up">
                    <div class="section-title">
                        <h3>AJUKAN PENGADUAN <span>SEKARANG</span></h3>
                        <p>Laporkan Masalah di Sekitar Anda dengan LaporPak.com</p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            @auth
                                @if (Auth::user()->role == 'Citizen')
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="{{ route('reports') }}" class="text-primary float-right">Daftar Laporan</a>
                                    </div>
                                @endif
                            @endauth
                            <div class="card">
                                <div class="card-header">
                                    Pengaduan
                                </div>

                                <div class="card-body">
                                    <form action="{{ route('reports.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Judul</label>
                                            <input type="text" class="form-control" id="title"
                                                value="{{ old('title') }}" name="title"
                                                placeholder="Masukan Judul Laporan">
                                            @error('title')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label ">Kategori</label>
                                            <select name="category_id" id="category_id" class="form-select select2">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if (old('category_id') == $category->id) selected @endif>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="region" class="form-label ">Wilayah <small>* yang
                                                    tersedia</small></label>
                                            <select name="region" id="region" class="form-select select2">
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region }}"
                                                        @if (old('region') == $region) selected @endif>
                                                        {{ $region }}</option>
                                                @endforeach
                                            </select>
                                            @error('region')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="location" class="form-label">Titik Lokasi</label>
                                            <div id="map"></div>
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="longitude" id="longitude">
                                            @error('latitude')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="attachments" class="form-label">Lampiran Pendukung</label>
                                            <input type="file" class="form-control" id="attachments"
                                                name="attachments[]" multiple>
                                            @error('attachments')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Ajukan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        <!-- ======= Frequently Asked Questions Section ======= -->
        <section id="faq" class="faq section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>F.A.Q</h2>
                    <h3>Frequently Asked <span>Questions</span></h3>
                    <p>Pertanyaan yang sering di ajukan</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <ul class="faq-list">
                            @foreach ($faqs as $faq)
                                <li>
                                    <div data-bs-toggle="collapse" class="collapsed question"
                                        href="#faq{{ $faq->id }}">{{ $faq->question }} <i
                                            class="bi bi-chevron-down icon-show"></i><i
                                            class="bi bi-chevron-up icon-close"></i></div>
                                    <div id="faq{{ $faq->id }}" class="collapse" data-bs-parent=".faq-list">
                                        <p>
                                            {{ $faq->answer }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </section><!-- End Frequently Asked Questions Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contact</h2>
                    <h3><span>Contact Us</span></h3>
                    <p>Kontak kami</p>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-4 col-md-12">
                        <div class="info-box mb-4">
                            <i class="bx bx-map"></i>
                            <h3>Our Address</h3>
                            <p>{{ $contact->address }}</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-envelope"></i>
                            <h3>Email Us</h3>
                            <p>{{ $contact->email }}</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-phone-call"></i>
                            <h3>Call Us</h3>
                            <p>{{ $contact->phone }}</p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->
@endsection


@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2();
        var map = L.map('map').setView([-6.200000, 106.816666], 13); // default view (Jakarta)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = null;

        function onMapClick(e) {
            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        }

        map.on('click', onMapClick);
    </script>
@endpush
