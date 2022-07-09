@extends('master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
<main id="main-container">
    <div class="content">
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="{{ route('pemohon.index') }}">Pemohon</a>
            <span class="breadcrumb-item active">Tambah Data</span>
        </nav>
        @include('alert')
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Form</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('pemohon.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" class="js-maxlength form-control" maxlength="16" name="nik" required value="{{ old('nik') }}">
                        @error('nik')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required value="{{ old('nama') }}">
                        @error('nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="form-control js-maxlength" maxlength="14" required value="{{ old('nomor_telepon') }}">
                        @error('nomor_telepon')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button class="btn btn-alt-info"><i class="si si-paper-plane"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
    <script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
@endpush

@section('js-helper')
['maxlength']
@endsection
