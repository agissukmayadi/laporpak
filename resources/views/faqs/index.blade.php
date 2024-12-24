@extends('layout.manage')

@section('title', 'Data FAQ')

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
                        <h3 class="card-title">Data FAQ</h3>
                        <button type="button" class="ml-auto btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#modal-create-faq"> <i class="fas fa-plus mr-2"></i> Tambah</button>
                        <div class="modal fade" id="modal-create-faq">
                            <div class="modal-dialog">
                                <form action="{{ route('faqs.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tambah FAQ</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="question">Pertanyaan</label>
                                                <textarea type="text" class="form-control" id="question" name="question" rows="3"
                                                    placeholder="Masukan Pertanyaan" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="answer">Jawaban</label>
                                                <textarea type="text" class="form-control" id="answer" name="answer" rows="5"
                                                    placeholder="Masukan Pertanyaan" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </form>
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $faq)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $faq->question }}</td>
                                        <td>{{ $faq->answer }}</td>
                                        <td>
                                            <div class=" d-flex">
                                                <button type="button" class="btn btn-sm btn-primary mr-2"
                                                    data-toggle="modal" data-target="#modal-edit-faq-{{ $faq->id }}"><i
                                                        class="fas fa-edit"></i></button>
                                                <div class="modal fade" id="modal-edit-faq-{{ $faq->id }}">
                                                    <div class="modal-dialog">
                                                        <form action="{{ route('faqs.update', $faq) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit FAQ</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="question">Pertanyaan</label>
                                                                        <textarea type="text" class="form-control" id="question" name="question" rows="3"
                                                                            placeholder="Masukan Pertanyaan" required>{{ $faq->question }}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="answer">Jawaban</label>
                                                                        <textarea type="text" class="form-control" id="answer" name="answer" rows="5"
                                                                            placeholder="Masukan Pertanyaan" required>{{ $faq->answer }}</textarea>
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
                                                <form action="{{ route('faqs.destroy', $faq) }}" method="POST"
                                                    onsubmit="return confirm('Apakah anda yakin?')" class=" d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
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
