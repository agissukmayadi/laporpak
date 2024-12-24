@extends('layout.manage')

@section('title', 'Tambah User')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title">Tambah User</h3>
                        <!-- /.modal -->
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="Nama Lengkap">
                                @error('name')
                                    <small class="text-danger ml-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="Email">
                                    @error('email')
                                        <small class="text-danger ml-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Nomor Handphone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone') }}" placeholder="Nomor Handphone">
                                    @error('phone')
                                        <small class="text-danger ml-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                        name="password">
                                    @error('password')
                                        <small class="text-danger ml-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Password Konfirmasi</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        placeholder="Password Konfirmasi" name="password_confirmation">
                                    @error('password_confirmation')
                                        <small class="text-danger ml-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role">Jenis User</label>
                                <select class="form-control" id="role" name="role" onchange="checkRole()">
                                    <option value="Citizen" {{ old('role') === 'Citizen' ? 'selected' : '' }}>Masyarakat
                                    </option>
                                    <option value="Goverment" {{ old('role') === 'Goverment' ? 'selected' : '' }}>
                                        Pemerintah</option>
                                    <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <small class="text-danger ml-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div id="provinceRegionContainer"
                                style="display: {{ old('role') === 'Goverment' ? 'block' : 'none' }};">
                                <div class="form-group">
                                    <label for="province" class="form-label text-color font-style">Provinsi</label>
                                    <select class="form-control" name="province" id="province" onchange="fetchCity()">
                                        <option selected disabled>Pilih Provinsi</option>
                                    </select>
                                    @error('province')
                                        <small class="text-danger ml-1 ">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="region" class="form-label text-color font-style">Kota</label>
                                    <select name="region" id="region" class="form-control">
                                        <option selected disabled>Pilih Kota</option>
                                    </select>
                                    @error('region')
                                        <small class="text-danger ml-1 ">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('users') }}" class="btn btn-default ml-2">Kembali</a>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
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
