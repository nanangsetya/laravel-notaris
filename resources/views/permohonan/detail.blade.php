@extends('master')

@push('css')
    <style>
        .form-control[readonly] {
            background-color: white !important;
        }

    </style>

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">

@endpush

@section('content')
<main id="main-container">
    <div class="content">
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="{{ route('permohonan.index') }}">Permohonan</a>
            <span class="breadcrumb-item active">Detail</span>
        </nav>

        @include('alert')

        <div class="block">
            <div class="block-content">
                <div class="form-group">
                    <label>Pemohon</label>
                    <input type="text" class="form-control" readonly="readonly" value="{{ $data->pemohon->nik }} - {{ $data->pemohon->nama }}">
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Jenis Berkas</label>
                            <input type="text" class="form-control" readonly="readonly" value="{{ $data->jenis_berkas->deskripsi }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nomor Sertifikat</label>
                            <input type="text" class="form-control" readonly value="{{ $data->nomor_sertifikat }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Desa</label>
                            <input type="text" class="form-control" readonly value="{{ $data->desa }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="block">
                                <div class="block-header block-header-default">KTP & KK Pihak Pertama</div>
                                <div class="block-content">
                                    @foreach(explode(",",$data->ktp) as $file)
                                        <button type="button" onclick="show_file('{{ asset('storage/upload/'.$file) }}')" class="btn btn-alt-primary"><i class="fa fa-file-pdf-o"></i> File</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="block">
                                <div class="block-header block-header-default">KTP & KK Pihak Kedua</div>
                                <div class="block-content">
                                    @foreach(explode(",",$data->kk) as $file)
                                        <button type="button" onclick="show_file('{{ asset('storage/upload/'.$file) }}')" class="btn btn-alt-primary"><i class="fa fa-file-pdf-o"></i> File</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="block">
                                <div class="block-header block-header-default">Sertifikat</div>
                                <div class="block-content">
                                    @foreach(explode(",",$data->sertifikat) as $file)
                                        <button type="button" onclick="show_file('{{ asset('storage/upload/'.$file) }}')" class="btn btn-alt-primary"><i class="fa fa-file-pdf-o"></i> File</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="block">
                                <div class="block-header block-header-default">PBB</div>
                                <div class="block-content">
                                    @foreach(explode(",",$data->pbb) as $file)
                                        <button type="button" onclick="show_file('{{ asset('storage/upload/'.$file) }}')" class="btn btn-alt-primary"><i class="fa fa-file-pdf-o"></i> File</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Status Berkas
                    @if(Auth::user()->id == $data->user_id)
                        <div class="pull-right">
                            <button type="button" class="btn btn-sm btn-alt-success" data-toggle="modal" data-target="#modal-berkas"><i class="si si-plus"></i> Tambah</button>
                        </div>
                    @endif
                </h3>
            </div>
            <div class="block-content">
                <table class="table table-bordered table-striped table-vcenter datatable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            @if(Auth::user()->id == $data->user_id)
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $r)
                            <tr>
                                <td>{{ $r->tanggal }}</td>
                                <td>{{ $r->keterangan }}</td>
                                <td>{{ $r->status_berkas->deskripsi }}</td>
                                @if(Auth::user()->id == $data->user_id)
                                    <td>
                                        <button type="button" onclick="edit_berkas('{{ $r->id }}','{{ $r->tanggal }}','{{ $r->keterangan }}','{{ $r->status_berkas_id }}')" class="btn btn-sm btn-alt-warning"><i class="si si-pencil"></i></button>
                                        <button type="button" onclick="remove_berkas('{{ $r->id }}')" class="btn btn-sm btn-alt-danger"><i class="si si-trash"></i></button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Pembayaran
                    @if(Auth::user()->id == $data->user_id)
                        <div class="pull-right">
                            <button type="button" class="btn btn-sm btn-alt-success" data-toggle="modal" data-target="#modal-bayar"><i class="si si-plus"></i> Tambah</button>
                        </div>
                    @endif
                </h3>
            </div>
            <div class="block-content">
                <table class="table table-bordered table-striped table-vcenter datatable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            @if(Auth::user()->id == $data->user_id)
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayaran as $p)
                            <tr>
                                <td>{{ date('d-m-Y',strtotime($p->tanggal)) }}</td>
                                <td align="right">{{ rupiah($p->nominal) }}</td>
                                <td>{{ $p->status_bayar->deskripsi }}</td>
                                @if(Auth::user()->id == $data->user_id)
                                    <td>
                                        <button type="button" onclick="edit_bayar('{{ $p->id }}','{{ $p->tanggal }}','{{ $p->nominal }}','{{ $p->status_bayar_id }}')" class="btn btn-sm btn-alt-warning"><i class="si si-pencil"></i></button>
                                        <button type="button" onclick="remove_bayar('{{ $p->id }}')" class="btn btn-sm btn-alt-danger"><i class="si si-trash"></i></button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Large Modal -->
<div class="modal" id="modal-file" tabindex="-1" role="dialog" aria-labelledby="modal-file" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">File</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END Large Modal -->

@if(Auth::user()->id == $data->user_id)
    <!-- berkas Modal -->
    <div class="modal fade" id="modal-berkas" tabindex="-1" role="dialog" aria-labelledby="modal-berkas" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <form action="{{ route('riwayat.store') }}" method="POST">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Status Berkas</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <input type="hidden" name="permohonan" value="{{ Request::route('id') }}">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="text" class="js-flatpickr form-control bg-white" name="tanggal" data-date-format="d-m-Y" value="{{ date('d-m-Y') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" required>
                            </div>

                            <div class="form-group">
                                <label for="">Status Berkas</label>
                                <select name="status_berkas" class="form-control" required>
                                    @foreach($status_berkas as $s)
                                        <option value="{{ $s->id }}">{{ $s->deskripsi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-alt-success">
                            <i class="si si-paper-plane"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END berkas Modal -->

    <!-- bayar Modal -->
    <div class="modal fade" id="modal-bayar" tabindex="-1" role="dialog" aria-labelledby="modal-bayar" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <form action="{{ route('pembayaran.store') }}" method="POST">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Pembayaran</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <input type="hidden" name="permohonan" value="{{ $data->id }}">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="text" class="js-flatpickr form-control bg-white" name="tanggal" data-date-format="d-m-Y" value="{{ date('d-m-Y') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="">Nominal</label>
                                <input type="text" class="form-control autonumeric" name="nominal" required>
                            </div>

                            <div class="form-group">
                                <label for="">Status bayar</label>
                                <select name="status_bayar" class="form-control" required>
                                    @foreach($status_bayar as $s)
                                        <option value="{{ $s->id }}">{{ $s->deskripsi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-alt-success">
                            <i class="si si-paper-plane"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END bayar Modal -->
@endif

@endsection

@push('script')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $('.datatable').DataTable({
            'sort': false
        });

    </script>

    @if(Auth::user()->id == $data->user_id)

        <script>
            function edit_berkas(id, tanggal, keterangan, status) {
                $("#modal-berkas input[name='id']").val(id);
                $("#modal-berkas input[name='tanggal']").val(tanggal);
                $("#modal-berkas input[name='keterangan']").val(keterangan);
                $("#modal-berkas select[name='status_berkas']").val(status).change();
                $("#modal-berkas").modal('show');
            }

            function remove_berkas(id) {
                Swal.fire({
                    title: 'Hapus data?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: "btn btn-sm btn-alt-danger",
                        cancelButton: "btn btn-sm btn-alt-secondary"
                    },
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{!! route('riwayat.delete',':id') !!}";
                        url = url.replace(':id', id);
                        location.href = url;
                    }
                })
            }

            function edit_bayar(id, tanggal, nominal, status) {
                $("#modal-bayar input[name='id']").val(id);
                $("#modal-bayar input[name='tanggal']").val(tanggal);
                $("#modal-bayar input[name='nominal']").val(nominal);
                $("#modal-bayar select[name='status_bayar']").val(status).change();
                $("#modal-bayar").modal('show');
            }

            function remove_bayar(id) {
                Swal.fire({
                    title: 'Hapus data?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: "btn btn-sm btn-alt-danger",
                        cancelButton: "btn btn-sm btn-alt-secondary"
                    },
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{!! route('pembayaran.delete',':id') !!}";
                        url = url.replace(':id', id);
                        location.href = url;
                    }
                })
            }

        </script>
    @endif

    <script>
        function show_file(path) {
            var html = '<object data="' + path + '" type="application/pdf" style="width:100%!important;height:500px!important"><embed src="' + path + '" height="800" type="application/pdf"><p>Browser ini tidak mendukung file PDF. Silakan unduh untuk melihat: <a href="' + path + '">UNDUH PDF KLIK DI SINI</a>.</p></object>';
            $('#modal-file .block-content').html(html);
            $('#modal-file').modal('show');
        }

    </script>
@endpush

@section('js-helper')
['flatpickr']
@endsection
