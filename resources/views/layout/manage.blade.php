@extends('layout.master')

@push('styles')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('storage/template/AdminLTE') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('storage/template/AdminLTE') }}/dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('storage/template/AdminLTE') }}/plugins/toastr/toastr.min.css">
@endpush


@section('body')
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <span class="brand-text font-weight-bold ml-3">LaporPak.</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block ml-3">
                            @if (Auth::user()->role == 'Admin')
                                Admin
                            @elseif(Auth::user()->role == 'Citizen')
                                Masyarakat
                            @elseif (Auth::user()->role == 'Goverment')
                                Pemerintah
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @if (Auth::user()->role == 'Admin')
                            <li class="nav-header">Master Data</li>
                            <li class="nav-item">
                                <a href="{{ route('users') }}"
                                    class="nav-link {{ request()->routeIs('users') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Data User
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories') }}"
                                    class="nav-link {{ request()->routeIs('categories') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>
                                        Data Kategori
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-header">Pengaduan</li>
                        <li class="nav-item">
                            <a href="{{ route('reports') }}"
                                class="nav-link {{ request()->routeIs('reports') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Data Pengaduan
                                </p>
                            </a>
                        </li>
                        @if (Auth::user()->role == 'Admin')
                            <li class="nav-header">Setting Website</li>
                            <li class="nav-item">
                                <a href="{{ route('about') }}"
                                    class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-info-circle"></i>
                                    <p>
                                        Tentang
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('contact') }}"
                                    class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-envelope"></i>
                                    <p>
                                        Kontak
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('faqs') }}"
                                    class="nav-link {{ request()->routeIs('faqs') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-question-circle"></i>
                                    <p>
                                        FAQ
                                    </p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-header"> Account </li>
                        <li class="nav-item">
                            <a href="{{ route('profile') }}"
                                class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profil Saya
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                        <!-- Formulir logout tersembunyi -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE') <!-- Menggunakan spoofing metode DELETE -->
                        </form>
                    </ul>
                </nav>


                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a href="https://laporpak.com">LaporPak</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Add Content Here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
@endsection

@prepend('script')
    <!-- jQuery -->
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('storage/template/AdminLTE') }}/dist/js/adminlte.min.js"></script>
    <!-- Toastr -->
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/toastr/toastr.min.js"></script>

    @if (session()->has('success'))
        <script>
            toastr.success('{{ session('success') }}')
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            toastr.error('{{ session('error') }}')
        </script>
    @endif
@endprepend
