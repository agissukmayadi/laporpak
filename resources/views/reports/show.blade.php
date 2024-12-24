@extends('layout.manage')

@section('title', 'Detail Laporan')

@push('script')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Detail Laporan</h3>
                    </div>
                    <div class="card-body">
                        <div>
                            <p class="text-muted ml-auto">{{ $report->code }} <span
                                    class="badge @if ($report->status == 'Pending') badge-warning
                    @elseif($report->status == 'Accepted') badge-info @elseif($report->status == 'Rejected') badge-danger @elseif ($report->status == 'In Progress') badge-primary @elseif ($report->status == 'Completed') badge-success @endif">{{ $report->status }}</span>
                            </p>
                            {{-- {{ $report->created_at->diffForHumans() }} --}}
                        </div>
                        <hr>
                        <div class="mb-4">
                            <dl class="row">
                                <dt class="col-sm-4">Judul Laporan</dt>
                                <dd class="col-sm-8">{{ $report->title }}</dd>
                                <dt class="col-sm-4">Kategori</dt>
                                <dd class="col-sm-8">{{ $report->category->name }}</dd>
                                <dt class="col-sm-4">Wilayah</dt>
                                <dd class="col-sm-8">{{ $report->region }}</dd>
                                @if ($report->note_rejected != null)
                                    <dt class="col-sm-4">Alasan Penolakan</dt>
                                    <dd class="col-sm-8">{{ $report->note_rejected }}</dd>
                                @endif
                                <dt class="col-sm-4">Prioritas</dt>
                                <dd class="col-sm-8">
                                    <span
                                        class="@if ($report->priority == 'Tinggi') text-danger
                                    @elseif($report->priority == 'Menengah') text-warning @else text-success @endif">
                                        {{ $report->priority }}</span>
                                </dd>
                                <dt class="col-sm-4">Tanggal Laporan</dt>
                                <dd class="col-sm-8">{{ $report->created_at->format('d M Y') }}</dd>
                            </dl>
                        </div>
                        <div class="mb-4">
                            <p class="font-weight-bold"> <span class="fas fa-info-circle mr-2"></span> Deskripsi Laporan</p>
                            <hr>
                            {!! $report->description !!}
                        </div>

                        <div class="mb-4">
                            <p class="font-weight-bold"> <span class="fas fa-map-marker-alt mr-2"></span> Lokasi</p>
                            <hr>
                            <div id="map"></div>
                        </div>

                        <div>
                            <p class="font-weight-bold"> <span class="fas fa-file mr-2"></span> Lampiran Pendukung</p>
                            <hr>
                            <ul>
                                @foreach ($report->attachments as $attachment)
                                    <li><a href="{{ asset('storage/' . $attachment->path) }}" target="_blank">Download
                                            Lampiran</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-12 col-md-4">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <h3 class="profile-username text-center">{{ $report->user->name }}</h3>

                        <p class="text-muted text-center">Pelapor</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Nama</b> <a class="float-right">{{ $report->user->name }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ $report->user->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>No. Telepon</b> <a class="float-right">{{ $report->user->phone }}</a>
                            </li>
                        </ul>

                        @if (Auth::user()->role == 'Admin' && $report->status == 'Pending')
                            <form action="{{ route('reports.verification', $report) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-block" name="status"
                                    onclick="return confirm('Are you sure?')" value="Accepted">
                                    <i class="fas fa-check mr-2"></i> Terima</button>
                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                    data-target="#modal-rejected-report"><i class="fas fa-times mr-2"></i> Tolak</button>
                            </form>
                            <div class="modal fade" id="modal-rejected-report">
                                <div class="modal-dialog">
                                    <form action="{{ route('reports.verification', $report) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tolak Laporan</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <input type="hidden" name="status" value="Rejected">
                                                <div class="form-group">
                                                    <label for="note_rejected">Alasan Penolakan</label>
                                                    <textarea class="form-control" id="note_rejected" name="note_rejected" placeholder="Masukan alasan penolakan" required></textarea>
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
                        @endif
                        @if (Auth::user()->role == 'Goverment' && $report->status == 'Accepted')
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                data-target="#modal-process-report"><i class="fas fa-redo mr-2"></i> Proses</button>
                            <div class="modal fade" id="modal-process-report">
                                <div class="modal-dialog">
                                    <form action="{{ route('reports.verification', $report) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Proses Laporan</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <input type="hidden" name="status" value="In Progress">
                                                <div class="form-group">
                                                    <label for="priority">Prioritas</label>
                                                    <select class="form-control" id="priority" name="priority" required>
                                                        <option value="Rendah">Rendah</option>
                                                        <option value="Menengah">Menengah</option>
                                                        <option value="Tinggi">Tinggi</option>
                                                    </select>
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
                        @endif
                        @if (Auth::user()->role == 'Goverment' && $report->status == 'In Progress')
                            <form action="{{ route('reports.verification', $report) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-block" name="status"
                                    onclick="return confirm('Are you sure?')" value="Completed">
                                    <i class="fas fa-check mr-2"></i> Selesaikan</button>
                            </form>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Komentar</h3>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: scroll">
                        @if (count($report->comments) > 0)
                            <!-- Post -->
                            <div class="post clearfix">
                                @foreach ($report->comments as $comment)
                                    <div class="user-block">
                                        <span class="username ml-0">
                                            <a class="text-primary">{{ $comment->user->name }}</a>
                                        </span>
                                        <span class="description ml-0">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        {{ $comment->comment }}
                                    </p>
                                @endforeach
                            </div>
                            <!-- /.post -->
                        @else
                            <p>Tidak ada komentar</p>
                        @endif
                    </div>
                    @if ((Auth::user()->role == 'Goverment' || Auth::user()->role == 'Citizen') && $report->status == 'In Progress')
                        <div class="card-footer">
                            <form class="form-horizontal" method="POST"
                                action="{{ route('reports.comment', $report) }}">
                                @csrf
                                <div class="input-group input-group-sm mb-0">
                                    <input class="form-control form-control-sm" name="comment"
                                        placeholder="Ketikan pesan">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-danger">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView(['{{ $report->latitude }}', '{{ $report->longitude }}'],
            13); // set to report location

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Add marker for the report location
        var marker = L.marker(['{{ $report->latitude }}', '{{ $report->longitude }}']).addTo(map)
            .bindPopup('Location')
            .openPopup();
    </script>
@endpush
