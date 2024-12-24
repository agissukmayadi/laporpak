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
            overflow: hidden;
        }

        /* Overlay for dark background effect */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            /* Adjust opacity as needed */
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
            /* Make sure form is above overlay */
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

        .form-label {
            font-size: 0.9rem;
        }

        .dropdown-toggle {
            width: 100%;
            background-color: white;
            border: 2px solid #4285F4;
            color: #4285F4;
            height: calc(2.2rem + 2px);
        }

        .dropdown-menu {
            background-color: white;
            border: 1px solid #4285F4;
        }

        .dropdown-item {
            color: #4285F4;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }
    </style>
@endpush

@section('content')
    <div class="container d-flex align-items-center justify-content-center">
        <form class="form-card" action="{{ route('register.store') }}" method="POST">
            @csrf
            <div id="isi-form">
                <h1 class="text-center text-color font-style fw-bold mb-3">DAFTAR</h1>
                <div class="mb-3">
                    <label for="fullName" class="form-label text-color font-style">Nama Lengkap atau Instansi</label>
                    <input type="text" id="fullName" class="form-control" placeholder="Nama" name="name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <small class="text-danger ms-1 mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-color font-style">Email</label>
                    <input type="email" id="email" class="form-control" placeholder="Email" name="email"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <small class="text-danger ms-1 mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label text-color font-style">No Handphone</label>
                    <input type="tel" id="phone" class="form-control" placeholder="No Handphone" name="phone"
                        value="{{ old('phone') }}" required>
                    @error('phone')
                        <small class="text-danger ms-1 mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-color font-style">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Password" name="password"
                        required>
                    @error('password')
                        <small class="text-danger ms-1 mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label text-color font-style">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                        placeholder="Konfirmasi Password" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label text-color font-style">Jenis User</label>
                    <select id="role" class="form-control" name="role" onchange="checkRole()" required>
                        <option disabled selected>Pilih Jenis User</option>
                        <option value="Citizen" {{ old('role') === 'Citizen' ? 'selected' : '' }}>Masyarakat</option>
                        <option value="Goverment" {{ old('role') === 'Goverment' ? 'selected' : '' }}>Pemerintah</option>
                    </select>
                    @error('role')
                        <small class="text-danger ms-1 mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div id="provinceRegionContainer" style="display: {{ old('role') === 'Goverment' ? 'block' : 'none' }};">
                    <div class="mb-3">
                        <label for="province" class="form-label text-color font-style">Provinsi</label>
                        <select class="form-control" name="province" id="province" onchange="fetchCity()">
                            <option selected disabled>Pilih Provinsi</option>
                        </select>
                        @error('province')
                            <small class="text-danger ms-1 mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="region" class="form-label text-color font-style">Kota</label>
                        <select name="region" id="region" class="form-control">
                            <option selected disabled>Pilih Kota</option>
                        </select>
                        @error('region')
                            <small class="text-danger ms-1 mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2">REGISTER</button>
            </div>
            <div class="row mt-1">
                <div class="col-12 text-center font-style">
                    Sudah Memiliki Akun?
                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-color">Login</a>
                </div>
            </div>

            <div class="row mt-2">
                <a href="{{ route('home') }}" class="text-primary text-center ">Kembali ke halaman utama</a>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        function checkRole() {
            const role = document.getElementById("role").value;
            const provinceRegionContainer = document.getElementById("provinceRegionContainer");

            // Tampilkan dropdown jika role adalah Goverment
            if (role === "Goverment") {
                provinceRegionContainer.style.display = "block";
                fetchProvince(); // Panggil fungsi untuk mengambil data provinsi
            } else {
                provinceRegionContainer.style.display = "none";
                document.getElementById("province").innerHTML = '<option selected disabled>Pilih Provinsi</option>';
                document.getElementById("region").innerHTML = '<option selected disabled>Pilih Kota</option>';
            }
        }

        function fetchProvince() {
            const province = document.getElementById("province");
            fetch(
                    "https://api.binderbyte.com/wilayah/provinsi?api_key=5d33709982b06eb4643a9ee623d33aa0da338dfa2b5feeadacacef7b59400ac6"
                )
                .then(response => response.json())
                .then(data => {
                    province.innerHTML = '<option selected disabled>Pilih Provinsi</option>';
                    data.value.forEach(prov => {
                        const option = document.createElement("option");
                        option.value = prov.id;
                        option.text = prov.name;
                        province.appendChild(option);
                    });
                })
        }

        function fetchCity() {
            const region = document.getElementById("region");
            const province = document.getElementById("province").value;
            fetch(
                    "https://api.binderbyte.com/wilayah/kabupaten?api_key=5d33709982b06eb4643a9ee623d33aa0da338dfa2b5feeadacacef7b59400ac6&id_provinsi=" +
                    province
                )
                .then(response => response.json())
                .then(data => {
                    region.innerHTML = '<option selected disabled>Pilih Kota</option>';
                    data.value.forEach(city => {
                        const option = document.createElement("option");
                        option.value = city.name;
                        option.text = city.name;
                        region.appendChild(option);
                    });
                })
        }
    </script>

    @if (old('role') === 'Goverment')
        <script>
            fetchProvince();
        </script>
    @endif
@endpush
