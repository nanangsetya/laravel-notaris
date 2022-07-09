@extends('master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('content')
<main id="main-container">
    <div class="content">
        <h2 class="content-heading">Data User</h2>
        @include('alert')
        <div class="block">
            <div class="block-header block-header-default">
                <a href="{{ route('user.create') }}" class="btn btn-sm btn-alt-success">Tambah</a>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $u)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $u->nama }}</td>
                                <td>{{ $u->username }}</td>
                                <td>{{ $u->role->deskripsi }}</td>
                                <td>{{ ($u->active == 1 ? 'Aktif':'Tidak Aktif') }}</td>
                                <td>
                                    <a href="{{ route('user.edit',['id' => $u->id]) }}" class="btn btn-sm btn-alt-warning"><i class="si si-pencil"></i></a>
                                    @if($u->active == 1)
                                        <button type="button" onclick="change_status('{{ $u->id }}','2')" class="btn btn-sm btn-alt-secondary" title="Nonaktifkan User"><i class="si si-user-unfollow"></i></button>
                                    @else
                                        <button type="button" onclick="change_status('{{ $u->id }}','1')" class="btn btn-sm btn-alt-success" title="Aktifkan User"><i class="si si-user-following"></i></button>
                                    @endif
                                    <button type="button" onclick="remove('{{ $u->id }}')" class="btn btn-sm btn-alt-danger"><i class="si si-trash"></i></button>
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
    <script src=" {{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(function () {
            $('.datatable').DataTable({
                aaSorting: false,
            });
        });

    </script>

    <script>
        function change_status(id, status) {
            Swal.fire({
                title: 'Yakin ' + (status == 1 ? 'aktifkan' : 'non-aktifkan') + ' user?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-sm btn-alt-danger",
                    cancelButton: "btn btn-sm btn-alt-secondary"
                },
                confirmButtonText: 'Ya, ' + (status == 1 ? 'aktifkan' : 'non-aktifkan') + '!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "{!! route('user.activation') !!}" + "?id=" + id + "&&status=" + status;
                }
            })
        }

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
                    var url = "{!! route('user.delete',':id') !!}";
                    url = url.replace(':id', id);
                    location.href = url;
                }
            })
        }

    </script>
@endpush
