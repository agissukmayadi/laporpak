@extends('layout.manage')

@section('title', 'Data Laporan')

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
                        <h3 class="card-title">Data Laporan</h3>
                        @if (Auth::user()->role == 'Citizen')
                            <a class="ml-auto btn btn-sm btn-primary" href="{{ route('reports.create') }}"> <i
                                    class="fas fa-plus mr-2"></i> Pengajuan</a>
                        @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Pelapor</th>
                                    <th>Kategori</th>
                                    <th>Judul</th>
                                    <th>Wilayah</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Goverment')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td><a href="{{ route('reports.show', $report) }}">{{ $report->code }}</a></td>
                                        <td>{{ $report->user->name }}</td>
                                        <td>{{ $report->category->name }}</td>
                                        <td>{{ $report->title }}</td>
                                        <td>{{ $report->region }}</td>
                                        <td>
                                            @if ($report->priority != null)
                                                <p
                                                    class="@if ($report->priority == 'Tinggi') text-danger
                                                        @elseif($report->priority == 'Menengah') text-warning @else text-success @endif">
                                                    {{ $report->priority }}</p>
                                            @else
                                                <p class="text-muted">N/A</p>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="badge @if ($report->status == 'Pending') badge-warning
                                        @elseif($report->status == 'Accepted') badge-info @elseif($report->status == 'Rejected') badge-danger @elseif ($report->status == 'In Progress') badge-primary @elseif ($report->status == 'Completed') badge-success @endif">{{ $report->status }}</span>
                                        </td>
                                        <td>{{ $report->created_at->format('d M Y') }}</td>
                                        @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Goverment')
                                            <td>
                                                @if (Auth::user()->role == 'Admin' && $report->status == 'Pending')
                                                    <form class="btn-group"
                                                        action="{{ route('reports.verification', $report) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success" name="status"
                                                            onclick="return confirm('Are you sure?')" value="Accepted">
                                                            <i class="fas fa-check"></i></button>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#modal-rejected-report"><i
                                                                class="fas fa-times"></i></button>
                                                    </form>
                                                    <div class="modal fade" id="modal-rejected-report">
                                                        <div class="modal-dialog">
                                                            <form action="{{ route('reports.verification', $report) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Tolak Laporan</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Rejected">
                                                                        <div class="form-group">
                                                                            <label for="note_rejected">Alasan
                                                                                Penolakan</label>
                                                                            <textarea class="form-control" id="note_rejected" name="note_rejected" placeholder="Masukan alasan penolakan" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    <!-- /.modal -->
                                                @endif
                                                @if (Auth::user()->role == 'Goverment' && $report->status == 'Accepted')
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modal-process-report"><i
                                                            class="fas fa-redo"></i></button>
                                                    <div class="modal fade" id="modal-process-report">
                                                        <div class="modal-dialog">
                                                            <form action="{{ route('reports.verification', $report) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Proses Laporan</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="In Progress">
                                                                        <div class="form-group">
                                                                            <label for="priority">Prioritas</label>
                                                                            <select class="form-control" id="priority"
                                                                                name="priority" required>
                                                                                <option value="Rendah">Rendah</option>
                                                                                <option value="Menengah">Menengah</option>
                                                                                <option value="Tinggi">Tinggi</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                @endif
                                                @if (Auth::user()->role == 'Goverment' && $report->status == 'In Progress')
                                                    <form action="{{ route('reports.verification', $report) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success" name="status"
                                                            onclick="return confirm('Are you sure?')" value="Completed">
                                                            <i class="fas fa-check"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Kode</th>
                                    <th>Pelapor</th>
                                    <th>Kategori</th>
                                    <th>Judul</th>
                                    <th>Wilayah</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Goverment')
                                        <th>Action</th>
                                    @endif
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
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
