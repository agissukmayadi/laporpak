@extends('layout.manage')

@section('title', 'Ubah Profil')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title">Ubah Profil</h3>
                        <!-- /.modal -->
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ auth()->user()->name }}" placeholder="Nama Lengkap">
                                @error('name')
                                    <small class="text-danger ml-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ auth()->user()->email }}" placeholder="Email">
                                    @error('email')
                                        <small class="text-danger ml-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Nomor Handphone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ auth()->user()->phone }}" placeholder="Nomor Handphone">
                                    @error('phone')
                                        <small class="text-danger ml-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <h5 class="text-muted"> Ubah Password <small>*Kosongkan jika tidak ingin diubah</small></h5>
                            <hr>
                            <div class="form-group">
                                <label for="old_password">Password Lama</label>
                                <input type="password" class="form-control" id="old_password" placeholder="Password Lama"
                                    name="old_password">
                                @error('old_password')
                                    <small class="text-danger ml-1">{{ $message }}</small>
                                @enderror
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
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
