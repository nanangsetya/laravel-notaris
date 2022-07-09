@extends('master')

@section('content')
<main id="main-container">
    <div class="content">
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="{{ route('user.index') }}">User</a>
            <span class="breadcrumb-item active">Tambah Data</span>
        </nav>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Form</h3>
            </div>
            @include('alert')
            <div class="block-content">
                <form action="{{ route('user.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required value="{{ $user->nama }}">
                        @error('nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required value="{{ $user->username }}">
                        @error('username')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control" placeholder="Kosongi jika tidak ingin merubah password">
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            @foreach($roles as $r)
                                <option value="{{ $r->id }}" {{ ($user->role_id == $r->id ? 'selected':'') }}>{{ $r->deskripsi }}</option>
                            @endforeach
                        </select>
                        @error('role')
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
