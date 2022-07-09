<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PembayaranExport implements FromView
{
    protected $year;

    function __construct($year)
    {
        $this->year = $year;
    }

    public function view(): View
    {
        $data = Pembayaran::with(['permohonan.jenis_berkas', 'permohonan.user', 'permohonan.pemohon']);
        if ($this->year != '') {
            $data = $data->whereYear('tanggal', $this->year);
        }
        $data = $data->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();

        return view('pembayaran.export', compact('data'));
    }
}
