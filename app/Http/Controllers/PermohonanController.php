<?php

namespace App\Http\Controllers;

use App\Exports\PermohonanExport;
use App\Models\JenisBerkas;
use App\Models\Pembayaran;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\StatusBayar;
use App\Models\StatusBerkas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class PermohonanController extends Controller
{
    function index_old(Request $r)
    {
        $data = Permohonan::with(['pemohon', 'user', 'jenis_berkas'])->with('riwayat_permohonan', function ($q) {
            $q->orderBy('tanggal', 'desc')->latest();
        });

        if ($r->year != '') {
            $data = $data->whereYear('created_at', $r->year);
        }

        $data = $data->orderBy('created_at', 'desc')->get();
        $tahun = Permohonan::select(DB::raw("distinct(year(created_at)) as tahun"))->orderBy('tahun', 'desc')->get();

        return view('permohonan.index', compact('data', 'tahun'));
    }

    function index()
    {
        $tahun = Permohonan::select(DB::raw("distinct(year(created_at)) as tahun"))->orderBy('tahun', 'desc')->get();

        return view('permohonan.index', compact('tahun'));
    }

    function datatable(Request $r)
    {
        $data = Permohonan::with(['pemohon', 'user', 'jenis_berkas', 'riwayat_latest.status_berkas']);
        if ($r->get('year')) {
            $data = $data->whereYear('created_at', $r->year);
        }
        $data = $data->orderBy('created_at', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('riwayat_keterangan', function ($data) {
                return ($data->riwayat_latest->keterangan ?? '');
            })
            ->addColumn('status_berkas_deskripsi', function ($data) {
                return ($data->riwayat_latest->status_berkas->deskripsi ?? '');
            })
            ->addColumn('action', function ($data) {
                $action = '<a href="' . route('permohonan.detail', ['id' => $data->id]) . '" class="btn btn-sm btn-alt-info"><i class="si si-eye"></i></a>';
                if (Auth::user()->id == $data->created_by) {
                    $action .= ' <a href="' . route('permohonan.edit', ['id' => $data->id]) . '" class="btn btn-sm btn-alt-warning"><i class="si si-pencil"></i></a>';
                    $action .= ' <button type="button" onclick="remove(' . $data->id . ')" class="btn btn-sm btn-alt-danger"><i class="si si-trash"></i></button>';
                }
                return $action;
            })
            ->make();
    }

    function create()
    {
        $jenis = JenisBerkas::all();
        return view('permohonan.create', compact('jenis'));
    }

    function store(Request $r)
    {
        $r->validate([
            'pemohon' => 'required',
            'jenis_berkas' => 'required',
            'nomor_sertifikat' => 'required',
            'desa' => 'required',
            'ktp' => 'required',
            'kk' => 'required',
            'sertifikat' => 'required',
            'pbb' => 'required',
        ]);

        if ($r->hasFile('ktp')) {
            $ktp_file = [];
            foreach ($r->file('ktp') as $file) {
                $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/upload/', $file, $filename);
                $ktp_file[] = $filename;
            }
        }

        if ($r->hasFile('kk')) {
            $kk_file = [];
            foreach ($r->file('kk') as $file) {
                $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/upload/', $file, $filename);
                $kk_file[] = $filename;
            }
        }

        if ($r->hasFile('sertifikat')) {
            $sertifikat_file = [];
            foreach ($r->file('sertifikat') as $file) {
                $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/upload/', $file, $filename);
                $sertifikat_file[] = $filename;
            }
        }

        if ($r->hasFile('pbb')) {
            $pbb_file = [];
            foreach ($r->file('pbb') as $file) {
                $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/upload/', $file, $filename);
                $pbb_file[] = $filename;
            }
        }

        $save = Permohonan::create([
            'pemohon_id' => $r->pemohon,
            'user_id' => Auth::user()->id,
            'jenis_berkas_id' => $r->jenis_berkas,
            'nomor_sertifikat' => $r->nomor_sertifikat,
            'desa' => $r->desa,
            'sertifikat' => implode(",", $sertifikat_file),
            'ktp' => implode(",", $ktp_file),
            'pbb' => implode(",", $pbb_file),
            'kk' => implode(",", $kk_file),
            'created_by' => Auth::user()->id,
        ]);

        if ($save) {
            return redirect()->route('permohonan.detail', $save->id)->with('success', 'Berhasil menyimpan');
        } else {
            return redirect()->back()->with('failed', 'Gagal menyimpan');
        }
    }

    function edit($id)
    {
        if (!Permohonan::find($id)) {
            return redirect()->route('permohonan.index');
        }

        $data = Permohonan::with(['pemohon', 'jenis_berkas'])->find($id);
        $jenis = JenisBerkas::all();

        return view('permohonan.edit', compact('data', 'jenis'));
    }

    function update(Request $r)
    {
        $r->validate([
            'id' => 'required',
            'pemohon' => 'required',
            'jenis_berkas' => 'required',
            'nomor_sertifikat' => 'required',
            'desa' => 'required',
        ]);

        $data = Permohonan::find($r->id);
        $data->pemohon_id = $r->pemohon;
        $data->jenis_berkas_id = $r->jenis_berkas;
        $data->nomor_sertifikat = $r->nomor_sertifikat;
        $data->desa = $r->desa;

        if ($r->hasFile('ktp')) {
            $ktp_file_new = [];
            foreach ($r->file('ktp') as $file) {
                $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/upload/', $file, $filename);
                $ktp_file_new[] = $filename;
            }

            $keep_file = array_intersect(explode(",", $data->ktp), $r->old_file_ktp);
            $deleted_file = array_diff(explode(",", $data->ktp), $r->ktp);
            foreach ($deleted_file as $d) {
                if (Storage::exists('public/upload/', $d)) {
                    Storage::delete('public/upload/' . $d);
                }
            }

            $data->ktp = implode(",", array_merge($ktp_file_new, $keep_file));
        }

        if ($r->hasFile('kk')) {
            $kk_file_new = [];
            foreach ($r->file('kk') as $file) {
                $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/upload/', $file, $filename);
                $kk_file_new[] = $filename;
            }

            $keep_file = array_intersect(explode(",", $data->kk), $r->old_file_kk);
            $deleted_file = array_diff(explode(",", $data->kk), $r->kk);
            foreach ($deleted_file as $d) {
                if (Storage::exists('public/upload/', $d)) {
                    Storage::delete('public/upload/' . $d);
                }
            }

            $data->kk = implode(",", array_merge($kk_file_new, $keep_file));
        }

        if ($r->hasFile('sertifikat')) {
            $sertifikat_file_new = [];
            foreach ($r->file('sertifikat') as $file) {
                $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/upload/', $file, $filename);
                $sertifikat_file_new[] = $filename;
            }

            $keep_file = array_intersect(explode(",", $data->sertifikat), $r->old_file_sertifikat);
            $deleted_file = array_diff(explode(",", $data->sertifikat), $r->sertifikat);
            foreach ($deleted_file as $d) {
                if (Storage::exists('public/upload/', $d)) {
                    Storage::delete('public/upload/' . $d);
                }
            }

            $data->sertifikat = implode(",", array_merge($sertifikat_file_new, $keep_file));
        }

        if ($r->hasFile('pbb')) {
            $pbb_file_new = [];
            foreach ($r->file('pbb') as $file) {
                $filename = time() . '_' . Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/upload/', $file, $filename);
                $pbb_file_new[] = $filename;
            }

            $keep_file = array_intersect(explode(",", $data->pbb), $r->old_file_pbb);
            $deleted_file = array_diff(explode(",", $data->pbb), $r->pbb);
            foreach ($deleted_file as $d) {
                if (Storage::exists('public/upload/', $d)) {
                    Storage::delete('public/upload/' . $d);
                }
            }

            $data->pbb = implode(",", array_merge($pbb_file_new, $keep_file));
        }

        $data->updated_by = Auth::user()->id;

        if ($data->save()) {
            return redirect()->back()->with('success', 'Berhasil menyimpan');
        } else {
            return redirect()->back()->with('failed', 'Gagal menyimpan');
        }
    }

    function delete($id)
    {
        if (!Permohonan::find($id)) {
            return redirect()->route('permohonan.index')->with('failed', 'Data tidak ditemukan');
        }

        $data = Permohonan::find($id);

        try {
            DB::beginTransaction();
            RiwayatPermohonan::where('permohonan_id', $id)->delete();
            Pembayaran::where('permohonan_id', $id)->delete();
            Permohonan::find($id)->delete();
            DB::commit();
            foreach (explode(",", $data->ktp) as $file) {
                if (Storage::exists('public/upload/', $file)) {
                    Storage::delete('public/upload/' . $file);
                }
            }

            foreach (explode(",", $data->kk) as $file) {
                if (Storage::exists('public/upload/', $file)) {
                    Storage::delete('public/upload/' . $file);
                }
            }

            foreach (explode(",", $data->sertifikat) as $file) {
                if (Storage::exists('public/upload/', $file)) {
                    Storage::delete('public/upload/' . $file);
                }
            }

            foreach (explode(",", $data->pbb) as $file) {
                if (Storage::exists('public/upload/', $file)) {
                    Storage::delete('public/upload/' . $file);
                }
            }
            return redirect()->route('permohonan.index')->with('success', 'Berhasil dihapus');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('permohonan.index')->with('failed', 'Gagal dihapus');
        }
    }

    function detail($id)
    {
        if (!Permohonan::find($id)) {
            return redirect()->route('permohonan.index');
        }

        $data = Permohonan::with(['pemohon', 'jenis_berkas'])->find($id);
        $riwayat = RiwayatPermohonan::with('status_berkas')->where('permohonan_id', $id)->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        $pembayaran = Pembayaran::with('status_bayar')->where('permohonan_id', $id)->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        $status_berkas = StatusBerkas::all();
        $status_bayar = StatusBayar::all();

        return view('permohonan.detail', compact('data', 'riwayat', 'pembayaran', 'status_bayar', 'status_berkas'));
    }

    function download_file($filename)
    {
        return Storage::download('public/upload/' . $filename);
    }

    public function export(Request $r)
    {
        return Excel::download(new PermohonanExport($r->year), 'data permohonan.xlsx');
    }
}
