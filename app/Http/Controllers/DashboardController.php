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
}
