<?php

namespace App\Exports;

use App\Models\Permohonan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PermohonanExport implements FromView
{
    protected $year;

    function __construct($year)
    {
        $this->year = $year;
    }

    public function view(): View
    {
        $data = Permohonan::with(['pemohon', 'user', 'jenis_berkas', 'riwayat_latest']);
        if ($this->year != '') {
            $data = $data->whereYear('created_at', $this->year);
        }
        $data = $data->orderBy('created_at', 'desc')->get();

        return view('permohonan.export', compact('data'));
    }
}
