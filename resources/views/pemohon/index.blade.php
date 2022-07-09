@extends('master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('content')
<main id="main-container">
    <div class="content">
        <h2 class="content-heading">Pemohon</h2>
        @include('alert')
        <div class="block">
            <div class="block-header block-header-default">
                <a href="{{ route('pemohon.create') }}" class="btn btn-sm btn-alt-success">Tambah</a>
            </div>
            <div class="block-content block-content-full">
                <table class="datatable table" id="pemohon-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
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
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(function () {
            $('#pemohon-table').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: "{!! route('pemohon.datatable') !!}",
                columns: [{
                        data: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'nama',
                    },
                    {
                        data: 'alamat',
                    },
                    {
                        data: 'no_telepon',
                    },
                    {
                        data: 'action',
                        orderable: 'false',
                        searchable: 'false'
                    },
                ]
            });
        });

    </script>

<script>
    function remove(nik) {
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
                var url = "{!! route('pemohon.delete',':nik') !!}";
                url = url.replace(':nik', nik);
                location.href = url;
            }
        })
    }

</script>
@endpush
