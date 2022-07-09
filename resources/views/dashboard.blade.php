@extends('master')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="mb-3">
            <form action="{{ route('dashboard') }}" method="GET" class="row">
                <div class="col-md-4 row">
                    <div class="col-6">
                        <select name="year" class="form-control">
                            <option value="">Semua</option>
                            @foreach($tahun as $t)
                                <option value="{{ $t->tahun }}" {{ Request::get('year') == $t->tahun ? 'selected':'' }}>{{ $t->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-block btn-alt-primary"><i class="si si-eye"></i> Show</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            <div class="col-6 col-xl-4">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-docs fa-2x text-primary-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-primary">{{ $data->permohonan }}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Permohonan</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-4">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-check fa-2x text-elegance-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-elegance">{{ $data->selesai }}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Selesai</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-4">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-wallet fa-2x text-earth-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-earth">{{ rupiah($data->pendapatan) }}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Pendapatan</div>
                    </div>
                </a>
            </div>
            <!-- END Row #1 -->
        </div>
    </div>
</main>
@endsection
