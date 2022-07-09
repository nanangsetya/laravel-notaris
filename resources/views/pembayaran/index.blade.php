@extends('master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('content')
<main id="main-container">
    <div class="content">
        <h2 class="content-heading">Pembayaran</h2>
        <div class="block">
            <div class="block-content block-content-full">
                <form action="{{ route('pembayaran.index') }}" method="GET" class="row">
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
            <div class="block-content block-content-full">
                <table class="datatable table table-bordered" id="table-pembayaran">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Bayar</th>
                            <th>Staff</th>
                            <th>Nomor Sertifikat</th>
                            <th>Jenis Permohonan</th>
                            <th>Nama Pemohon</th>
                            <th>Nominal</th>
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

    <script>
        function exports() {
            window.location.href = "{!! route('pembayaran.export') !!}" + "?year=" + $('#year option:selected').val();
        }

        $(function () {
            $('#table-pembayaran').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: {
                    url: "{!! route('pembayaran.datatable') !!}",
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
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'permohonan.user.nama',
                        name: 'permohonan.user.nama'
                    },

                    {
                        data: 'permohonan.nomor_sertifikat',
                        name: 'permohonan.nomor_sertifikat'
                    },
                    {
                        data: 'permohonan.jenis_berkas.deskripsi',
                        name: 'permohonan.jenis_berkas.deskripsi'
                    },
                    {
                        data: 'permohonan.pemohon.nama',
                        name: 'permohonan.pemohon.nama'
                    },
                    {
                        data: 'nominal',
                        'searchable': false
                    },
                ],
                'columnDefs': [{
                    "targets": 6,
                    "className": "text-right",
                }],
            });
        });

    </script>
@endpush
