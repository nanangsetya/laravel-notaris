@extends('master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('content')
<main id="main-container">
    <div class="content">
        <h2 class="content-heading">Permohonan</h2>
        @include('alert')
        <div class="block">
            <div class="block-content block-content-full">
                <form method="GET" class="row" id="search-form">
                    <div class="col-sm-4">
                        <select name="year" class="form-control" id="year">
                            <option value="">Semua</option>
                            @foreach($tahun as $t)
                                <option value="{{ $t->tahun }}" {{ Request::get('year') == $t->tahun ? 'selected':'' }}>{{ $t->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-block btn-alt-info"><i class="si si-eye"></i> Show</button>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-block btn-alt-success" onclick="exports()"><i class="fa fa-file-excel-o"></i> Export</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="block">
            @if(Auth::user()->role_id ==3)
                <div class="block-header block-header-default">
                    <a href="{{ route('permohonan.create') }}" class="btn btn-sm btn-alt-success">Tambah</a>
                </div>
            @endif
            <div class="block-content block-content-full">
                <table class="table table-bordered table-hover datatable" id="table-permohonan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemegang</th>
                            <th>Jenis</th>
                            <th>Pemohon</th>
                            <th>Nomor Sertifikat</th>
                            <th>Desa</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        function exports() {
            window.location.href = "{!! route('permohonan.export') !!}" + "?year=" + $('#year option:selected').val();
        }

        $(function () {
            $('#table-permohonan').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: {
                    url: "{!! route('permohonan.datatable') !!}",
                    data: function (d) {
                        d.year = "{!!Request::get('year')!!}";
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        data: 'user.nama',
                        name: 'user.nama',
                    },
                    {
                        data: 'jenis_berkas.deskripsi',
                        name: 'jenis_berkas.deskripsi',
                    },
                    {
                        data: 'pemohon.nama',
                        name: 'pemohon.nama',
                    },
                    {
                        data: 'nomor_sertifikat',
                        name: 'nomor_sertifikat',
                    }, 
                    {
                        data: 'desa',
                        name: 'desa',
                    },
                    {
                        data: 'riwayat_keterangan',
                        name: 'riwayat_latest.keterangan',
                    },
                    {
                        data: 'status_berkas_deskripsi',
                        name: 'riwayat_latest.status_berkas.deskripsi',
                    },
                    {
                        data: 'action',
                        'orderable': false,
                        'searchable': false
                    }
                ]
            });
        });

    </script>

    <script>
        function remove(id) {
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
                    var url = "{!! route('permohonan.delete',':id') !!}";
                    url = url.replace(':id', id);
                    location.href = url;
                }
            })
        }

    </script>
@endpush
