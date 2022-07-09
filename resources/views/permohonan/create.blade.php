@extends('master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/jquery-filer/css/jquery.filer.css') }}">
@endpush

@section('content')
<main id="main-container">
    <div class="content">
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="{{ route('permohonan.index') }}">Permohonan</a>
            <span class="breadcrumb-item active">Tambah Data</span>
        </nav>

        @include('alert')

        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Form</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('permohonan.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Pemohon</label>
                        <select class="js-select2 form-control" id="pemohon" name="pemohon" style="width: 100%;" required>
                        </select>
                        @error('pemohon')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-sm btn-alt-info" data-toggle="modal" data-target="#modal-pemohon"><i class="si si-plus"></i> Tambah pemohon</button>
                    </div>

                    <div class="form-group">
                        <label for="">Jenis Berkas</label>
                        <select name="jenis_berkas" class="form-control" required>
                            @foreach($jenis as $j)
                                <option value="{{ $j->id }}">{{ $j->deskripsi }}</option>
                            @endforeach
                        </select>
                        @error('jenis_berkas')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nomor Sertifikat</label>
                                <input type="text" class="form-control" name="nomor_sertifikat" required>
                                @error('nomor_sertifikat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Desa</label>
                                <input type="text" class="form-control" name="desa" required>
                                @error('desa')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="block">
                                    <div class="block-header block-header-default">KTP & KK Pihak Pertama</div>
                                    <div class="block-content">
                                        <input type="file" class="filer_input" name="ktp[]" required multiple="multiple">
                                        @error('ktp')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="block">
                                    <div class="block-header block-header-default">KTP & KK Pihak Kedua</div>
                                    <div class="block-content">
                                        <input type="file" class="filer_input" name="kk[]" required multiple="multiple">
                                        @error('kk')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
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
                                        <input type="file" class="filer_input" name="sertifikat[]" required multiple="multiple">
                                        @error('sertifikat')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="block">
                                    <div class="block-header block-header-default">PBB</div>
                                    <div class="block-content">
                                        <input type="file" class="filer_input" name="pbb[]" required multiple="multiple">
                                        @error('pbb')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-alt-primary"><i class="si si-paper-plane"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Pop Out Modal -->
<div class="modal fade" id="modal-pemohon" tabindex="-1" role="dialog" aria-labelledby="modal-pemohon" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <form id="add-pemohon">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Tambah Pemohon</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label for="">NIK</label>
                            <input type="text" name="nik" class="js-maxlength form-control" maxlength="16" required>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="alamat" required class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label for="">Nomor Telepon</label>
                            <input type="text" name="telepon" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-alt-success">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END Pop Out Modal -->
@endsection

@push('script')
    <script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-filer/js/jquery.filer.min.js') }}"></script>

    <script type="text/javascript">
        $('.js-select2').select2({
            placeholder: 'Cari pemohon',
            ajax: {
                url: "{!! route('pemohon.dataAjax') !!}",
                dataType: 'json',
                type: 'GET',
                delay: 250,
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            "language": {
                "noResults": function () {
                    return "Data tidak ditemukan";
                }
            },
        });

    </script>

    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#add-pemohon').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{!! route('pemohon.store') !!}",
                type: "POST",
                dataType: "json",
                data: {
                    nik: $('#modal-pemohon [name="nik"]').val(),
                    nama: $('#modal-pemohon [name="nama"]').val(),
                    telepon: $('#modal-pemohon [name="telepon"]').val(),
                    alamat: $('#modal-pemohon [name="alamat"]').val(),
                },
                success: function (response) {
                    $('#modal-pemohon').modal('hide');
                    notification(response.type, response.message);
                },
                error: function (response) {
                    $('#modal-pemohon').modal('hide');
                    notification('danger', 'Terjadi error. Refresh halaman ini !');
                },
            });
        });

        function notification(type, message) {
            Codebase.helpers('notify', {
                align: 'right', // 'right', 'left', 'center'
                from: 'top', // 'top', 'bottom'
                type: type, // 'info', 'success', 'warning', 'danger'
                message: message
            });
        }

    </script>

    <script>
        $('.filer_input').filer({
            showThumbs: true,
            addMore: true,
            allowDuplicates: false,
            extensions: ['pdf'],
            captions: {
                button: "Cari",
                feedback: "Pilih file untuk diupload",
                feedback2: "files were chosen",
                drop: "Drop file here to Upload",
                removeConfirmation: "Hapus file?",
                errors: {
                    filesLimit: "Only @{{ fi-limit }} files are allowed to be uploaded.",
                    filesType: 'Ekstensi pdf yang diperbolehkan.',
                    filesSize: "@{{ fi-name }} is too large! Please upload file up to @{{ fi-fileMaxSize }} MB.",
                    filesSizeAll: "Files you've choosed are too large! Please upload files up to @{{ fi-maxSize }} MB.",
                    folderUpload: "You are not allowed to upload folders."
                }
            }
        });

    </script>
@endpush

@section('js-helper')
['notify','maxlength']
@endsection
