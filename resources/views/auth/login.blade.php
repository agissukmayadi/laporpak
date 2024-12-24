@extends('layout.auth')

@push('styles')
    <style>
        body {
            background-image: url("{{ asset('storage/img/backroundImage.png') }}");
            background-size: cover;
            background-position: center;
            font-family: 'Roboto', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .form-card {
            background-color: white;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            max-width: 500px;
            width: 100%;
            border-radius: 10px;
            margin: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .form-control {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .text-color {
            color: #4285F4 !important;
        }

        .font-style {
            font-family: 'Roboto', sans-serif;
        }

        .google-btn-icon {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="container d-flex align-items-center justify-content-center">
        <form class="form-card" action="{{ route('login') }}" method="POST">
            @csrf
            <div id="isi-form">
                <h1 class="text-center text-color fw-bold font-style mb-4">LOGIN</h1>

                <div class="row mb-3">
                    <div class="col-12">
                        <input type="email" class="form-control" placeholder="Email" name="email"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger ms-1 mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <input type="password" class="form-control" placeholder="Kata Sandi" name="password" required>
                        @error('password')
                            <small class="text-danger ms-1 mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="row mb-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <button type="button" class="btn btn-outline-primary w-100 mt-2">
                            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google Icon"
                                class="google-btn-icon" style="width: 20px; height: 20px;">
                            Sign in with Google
                        </button>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-12 text-center font-style">
                        Tidak Memiliki Akun?
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none text-color">Daftar</a>
                    </div>
                </div>

                <div class="row mt-2">
                    <a href="{{ route('home') }}" class="text-primary text-center ">Kembali ke halaman utama</a>
                </div>
            </div>
        </form>
    </div>
@endsection
