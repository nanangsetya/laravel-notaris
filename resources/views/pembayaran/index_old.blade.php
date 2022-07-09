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
                        <select name="year" class="form-control">
                            <option value="">Semua</option>
                            @foreach($tahun as $t)
                                <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-block btn-alt-info"><i class="si si-eye"></i> Show</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="block">
            <div class="block-content block-content-full">
                <table class="datatable table table-bordered">
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
                    <tbody>
                        @foreach($data as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->tanggal }}</td>
                                <td>{{ $d->permohonan->user->nama }}</td>
                                <td>{{ $d->permohonan->nomor_sertifikat }}</td>
                                <td>{{ $d->permohonan->jenis_berkas->deskripsi }}</td>
                                <td>{{ $d->permohonan->pemohon->nama }}</td>
                                <td align="right">{{ rupiah($d->nominal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script>
        $('.datatable').DataTable({
            'aaSorting': false,
            dom: 'Bfrtip',
            "buttons": [{
                    "extend": 'excel',
                    "text": '<i class="fa fa-file-excel-o"></i> Export',
                    "className": 'btn btn-alt-success btn-sm',
                    "title": 'Data Pembayaran',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                // {
                //     "extend": 'pdf',
                //     "text": '<i class="fa fa-file-pdf-o"></i> Pdf',
                //     "className": 'btn btn-alt-danger btn-xs'
                // }
            ],
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ]
        });

    </script>
@endpush
