<?php

namespace App\Http\Controllers;

use App\Exports\PembayaranExport;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranController extends Controller
{

    function index(Request $r)
    {
        $tahun = Pembayaran::select(DB::raw("distinct(year(tanggal)) as tahun"))->orderBy('tahun', 'desc')->get();

        return view('pembayaran.index', compact('tahun'));
    }

    function datatable(Request $r)
    {
        $data = Pembayaran::with(['permohonan.jenis_berkas', 'permohonan.user', 'permohonan.pemohon'])->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');
        if ($r->get('year')) {
            $data = $data->whereYear('tanggal', $r->year);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nominal', function ($data) {
                return rupiah($data->nominal);
            })->make(true);
    }

    function store(Request $r)
    {
        $save = Pembayaran::updateOrCreate(
            ['id' => $r->id],
            [
                'permohonan_id' => $r->permohonan,
                'status_bayar_id' => $r->status_bayar,
                'tanggal' => date('Y-m-d', strtotime($r->tanggal)),
                'nominal' => str_replace([',00', '.'], '', $r->nominal),
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
        if (!Pembayaran::find($id)) {
            return redirect()->back()->with('failed', 'Data tidak ditemukan');
        }

        $data = Pembayaran::find($id);
        if ($data->delete()) {
            return redirect()->back()->with('success', 'Berhasil dihapus');
        } else {
            return redirect()->back()->with('failed', 'Gagal dihapus');
        }
    }

    public function export(Request $r)
    {
        return Excel::download(new PembayaranExport($r->year), 'data pembayaran.xlsx');
    }
}
