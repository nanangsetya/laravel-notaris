@extends('master')

@section('content')
<main id="main-container">
    <div class="content">
        <h2 class="content-heading">Tracking</h2>
        <div class="block">
            <div class="block-content block-content-full">
                <form action="{{ route('tracking') }}" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="track" class="form-control" placeholder="Masukkan kode sertifikat" value="{{ request()->track }}">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-alt-primary"><i class="si si-magnifier"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(count($track))
        <div class="content">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Hasil Pencarian</h3>
                </div>
                <div class="block-content">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        @foreach($track as $t)
                            <div class="block block-bordered block-rounded mb-2">
                                <div class="block-header" role="tab" id="accordion_h{{ $t['id'] }}">
                                    <a class="font-w600" data-toggle="collapse" data-parent="#accordion" href="#accordion_q{{ $t['id'] }}" aria-expanded="true" aria-controls="accordion_q{{ $t['id'] }}">
                                        {{ $t['nomor_sertifikat'].' ('. $t['jenis'].')' }} - {{ $t['pemohon'] }}
                                    </a>
                                </div>
                                <div id="accordion_q{{ $t['id'] }}" class="collapse" role="tabpanel" aria-labelledby="accordion_h{{ $t['id'] }}" data-parent="#accordion">
                                    @if(count($t['history']) > 0)
                                        <div class="block-content">
                                            <ul class="list list-timeline list-timeline-modern pull-t">
                                                @foreach($t['history'] as $h)
                                                    <li>
                                                        <div class="list-timeline-time">{{ $h['tanggal'] }}</div>
                                                        <i class="list-timeline-icon fa fa-calendar {{ ($h['no'] == 1 ? 'bg-info' :'bg-gray') }}"></i>
                                                        <div class="list-timeline-content">
                                                            <p class="font-w600">{{ $h['status_berkas'] }}</p>
                                                            <p>{{ $h['keterangan'] }}</p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <div class="block-content">
                                            <p>Riwayat belum tersedia</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="content">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Tidak Ditemukan</h3>
                </div>
            </div>
        </div>
    @endif
</main>
@endsection
