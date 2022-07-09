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
                <form action="{{ route('permohonan.index') }}" method="GET" class="row">
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
            @if(Auth::user()->role_id ==3)
                <div class="block-header block-header-default">
                    <a href="{{ route('permohonan.create') }}" class="btn btn-sm btn-alt-success">Tambah</a>
                </div>
            @endif
            <div class="block-content block-content-full">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemegang</th>
                            <th>Jenis</th>
                            <th>Pemohon</th>
                            <th>Nomor Sertifikat - Desa</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->user->nama }}</td>
                                <td>{{ $d->jenis_berkas->deskripsi }}</td>
                                <td>{{ $d->pemohon->nama }}</td>
                                <td>{{ $d->nomor_sertifikat.' - '.$d->desa }}</td>
                                <td>{{ ($d->riwayat_permohonan->first()->keterangan ?? '') }}</td>
                                <td>{{ ($d->riwayat_permohonan->first()->status_berkas->deskripsi ?? '') }}</td>
                                <td>
                                    <a href="{{ route('permohonan.detail',['id' => $d->id]) }}" class="btn btn-sm btn-alt-info"><i class="si si-eye"></i></a>
                                    @if(Auth::user()->id == $d->created_by)
                                        <a href="{{ route('permohonan.edit',['id' => $d->id]) }}" class="btn btn-sm btn-alt-warning"><i class="si si-pencil"></i></a>
                                        <button type="button" onclick="remove('{{ $d->id }}')" class="btn btn-sm btn-alt-danger"><i class="si si-trash"></i></button>
                                    @endif
                                </td>
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
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script>
        $(function () {
            $('.datatable').DataTable({
                "columnDefs": [{
                    "targets": 7,
                    "orderable": false
                }],
                dom: 'Bfrtip',
                "buttons": [{
                    "extend": 'excel',
                    "text": '<i class="fa fa-file-excel-o"></i> Export',
                    "className": 'btn btn-alt-success btn-sm',
                    "title": 'Data Permohonan',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                }, ]
            });
            $('#permohonan-table').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: "{!! route('permohonan.datatable') !!}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nomor_sertifikat',
                        name: 'nomor_sertifikat'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: '',
                        name: ''
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
