<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPermohonanController extends Controller
{
    function store(Request $r)
    {
        $save = RiwayatPermohonan::updateOrCreate(
            ['id' => $r->id],
            [
                'permohonan_id' => $r->permohonan,
                'status_berkas_id' => $r->status_berkas,
                'tanggal' => date('Y-m-d', strtotime($r->tanggal)),
                'keterangan' => $r->keterangan,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );

        if ($save) {
            return redirect()->back()->with('success', 'Berhasil disimpan');
        } else {
            return redirect()->back()->with('failed', 'Gagal disimpan');
        }
    }

    function delete($id)
    {
        if (!RiwayatPermohonan::find($id)) {
            return redirect()->back()->with('failed', 'Data tidak ditemukan');
        }

        $data = RiwayatPermohonan::find($id);
        if ($data->delete()) {
            return redirect()->back()->with('success', 'Berhasil dihapus');
        } else {
            return redirect()->back()->with('failed', 'Gagal dihapus');
        }
    }
}
