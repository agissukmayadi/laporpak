@extends('layout.manage')

@section('title', 'Data User')

@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title">Data User</h3>
                        <a href="{{ route('users.create') }}" class="ml-auto btn btn-sm btn-primary"> <i
                                class="fas fa-plus mr-2"></i> Tambah</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. Handphone</th>
                                    <th>Role</th>
                                    <th>Region</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            @if ($user->region != null)
                                                {{ $user->region }}
                                            @else
                                                <p class="text-muted">N/A</p>
                                            @endif
                                        </td>
                                        <td><span
                                                class="badge
                                                @if ($user->is_verified) badge-success
                                                @else badge-danger @endif ">{{ $user->is_verified ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('users.verification', $user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                @if ($user->is_verified)
                                                    <button class="btn btn-sm btn-danger" name="is_verified" value="0"
                                                        type="submit"
                                                        onclick="return confirm('Are you sure you want to deactivate this user?')"><i
                                                            class="fas fa-times"></i></button>
                                                @else
                                                    <button class="btn btn-sm btn-success" name="is_verified" value="1"
                                                        type="submit"
                                                        onclick="return confirm('Are you sure you want to activate this user?')"><i
                                                            class="fas fa-check"></i></button>
                                                @endif
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('users.edit', $user) }}"><i class="fas fa-edit"></i></a>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. Handphone</th>
                                    <th>Role</th>
                                    <th>Region</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js">
    </script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
    </script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js">
    </script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js">
    </script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('storage/template/AdminLTE') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
