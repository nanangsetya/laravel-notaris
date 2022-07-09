<?php

namespace App\Http\Controllers;

use App\Models\Pemohon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PemohonController extends Controller
{
    function index()
    {
        return view('pemohon.index');
    }

    function datatable()
    {
        $data = Pemohon::select([
            'id',
            'nik',
            'nama',
            'alamat',
            'no_telepon'
        ])->get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $button = '<a href="' . route('pemohon.edit', $data->id) . '" class="btn btn-sm btn-alt-warning"><i class="si si-pencil"></i></a>';
                if ($data->permohonan->count() < 1) {
                    $button .= ' <button onclick="remove(' . $data->nik . ')" class="btn btn-sm btn-alt-danger"><i class="si si-trash"></i></button>';
                }
                return $button;
            })
            ->addIndexColumn()
            ->make(true);
    }

    function dataAjax(Request $r)
    {
        $response = [];
        $search = ($r->has('q') ? $r->q : '');
        $data = Pemohon::select('id', 'nik', 'nama')->where('nik', 'LIKE', "%$search%")->orWhere('nama', 'LIKE', "%$search%")->get();
        foreach ($data as $d) {
            $response[] = [
                'id' => "$d->id",
                'text' => "$d->nik - $d->nama"
            ];
        }

        return response()->json($response);
    }

    function create()
    {
        return view('pemohon.create');
    }

    function store(Request $r)
    {
        if ($r->ajax()) {
            if (Pemohon::where('nik', $r->nik)->get()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'type' => 'info',
                    'message' => 'NIK sudah terdaftar'
                ]);
            }

            $save = Pemohon::create([
                'nik' => $r->nik,
                'nama' => $r->nama,
                'no_telepon' => $r->telepon,
                'alamat' => $r->alamat,
                'created_by' => Auth::user()->id
            ]);

            if ($save) {
                return response()->json([
                    'type' => 'info',
                    'message' => 'Berhasil menambahkan'
                ]);
            } else {
                return response()->json([
                    'type' => 'danger',
                    'message' => 'Terjadi error. Refresh halaman ini !'
                ]);
            }
        } else {
            $r->validate([
                'nik' => 'required|unique:pemohon|numeric|digits_between:1,16',
                'nama' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required|numeric|digits_between:1,14'
            ]);

            $save = Pemohon::create([
                'nik' => $r->nik,
                'nama' => $r->nama,
                'no_telepon' => $r->nomor_telepon,
                'alamat' => $r->alamat,
                'created_by' => Auth::user()->id
            ]);

            if ($save) {
                return redirect()->route('pemohon.index')->with('success', 'Berhasil disimpan.');
            } else {
                return redirect()->back()->with('failed', 'Gagal disimpan.')->withInput();
            }
        }
    }

    function edit($id)
    {
        if (!Pemohon::find($id)) {
            return redirect()->back()->with('failed', 'Pemohon tidak ditemukan.');
        }

        $data = Pemohon::find($id);
        return view('pemohon.edit', compact('data'));
    }

    function update(Request $r)
    {
        $r->validate([
            'nik' => 'required|numeric|digits_between:1,16|unique:pemohon,nik,' . $r->id,
            'nama' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required|numeric|digits_between:1,14'
        ]);

        $data = Pemohon::find($r->id);
        $data->nik = $r->nik;
        $data->nama = $r->nama;
        $data->no_telepon = $r->nomor_telepon;
        $data->alamat = $r->alamat;
        $data->updated_by = Auth::user()->id;

        if ($data->save()) {
            return redirect()->route('pemohon.index')->with('success', 'Berhasil disimpan.');
        } else {
            return redirect()->back()->with('failed', 'Gagal disimpan.')->withInput();
        }
    }

    function delete($nik)
    {
        if (!Pemohon::where('nik', $nik)) {
            return redirect()->back()->with('failed', 'Pemohon tidak ditemukan.');
        }

        $data = Pemohon::where('nik', $nik);
        if ($data->delete()) {
            return redirect()->back()->with('success', 'Berhasil dihapus');
        } else {
            return redirect()->back()->with('failed', 'Gagal dihapus');
        }
    }
}
