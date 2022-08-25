<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index(Request $r)
    {
        $year = ($r->has('year') ? $r->year : '');
        $tahun = Permohonan::select(DB::raw("distinct(year(created_at)) as tahun"))->orderBy('tahun', 'desc')->get();

        $data = DB::table('permohonan as p')->select(
            DB::raw('count(p.id) as permohonan'),
            DB::raw("(select sum(nominal) from pembayaran join permohonan on pembayaran.permohonan_id = permohonan.id where year(pembayaran.created_at) like '%$year%') as pendapatan"),
            DB::raw("(select count(permohonan.id) from permohonan join riwayat_permohonan as r on permohonan.id = r.permohonan_id where status_berkas_id = 4 and year(permohonan.created_at) like '%$year%') as selesai")
        )->whereYear('created_at', 'like', '%' . $year . '%')->get()->first();

        return view('dashboard', compact('data', 'tahun'));
    }

    function tracking(Request $r)
    {
        $track = [];
        if (isset($r->track) || $r->track != '') {
            $search = Permohonan::with(['riwayat_permohonan' => function ($q) {
                $q->orderBy('riwayat_permohonan.tanggal', 'desc');
            }])->with('pemohon')->with('jenis_berkas')->where('nomor_sertifikat', $r->track)->get();
            foreach ($search as $s) {
                $history = [];
                if ($s->riwayat_permohonan != null) {
                    $i = 1;
                    foreach ($s->riwayat_permohonan as $r) {
                        $history[] = [
                            'no' => $i++,
                            'tanggal' => date('d-m-Y', strtotime($r->tanggal)),
                            'keterangan' => $r->keterangan,
                            'status_berkas' => $r->status_berkas->deskripsi
                        ];
                    }
                }
                $track[] = [
                    'id' => $s->id,
                    'pemohon' => $s->pemohon->nama,
                    'nomor_sertifikat' => $s->nomor_sertifikat,
                    'jenis' => $s->jenis_berkas->deskripsi,
                    'history' => $history
                ];
            }
        }

        return view('tracking', compact('track'));
    }
}
