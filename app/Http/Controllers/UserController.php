<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index()
    {
        $user = User::with('role')->orderBy('role_id', 'asc')->get();
        return view('user.index', compact('user'));
    }

    function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    function store(Request $r)
    {
        $r->validate([
            'nama' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);

        $save = User::create([
            'nama' => $r->nama,
            'username' => $r->username,
            'password' => Hash::make($r->password),
            'role_id' => $r->role,
            'active' => 1,
            'created_by' => Auth::user()->id
        ]);

        if ($save) {
            return redirect()->route('user.index')->with('success', 'Berhasil disimpan');
        } else {
            return redirect()->back()->with('failed', 'Gagal disimpan');
        }
    }

    function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('user.edit', compact('roles', 'user'));
    }

    function update(Request $r)
    {
        $r->validate([
            'id' => 'required',
            'nama' => 'required',
            'username' => 'required|unique:users,username,' . $r->id,
            'role' => 'required'
        ]);

        $data = User::find($r->id);
        $data->nama = $r->nama;
        $data->username = $r->username;
        ($r->password == '' ? $data->password = Hash::make($r->password) : '');
        $data->role_id = $r->role;
        $data->updated_by = Auth::user()->id;

        if ($data->save()) {
            return redirect()->back()->with('success', 'Berhasil disimpan');
        } else {
            return redirect()->back()->with('failed', 'Gagal disimpan');
        }
    }

    function activation(Request $r)
    {
        if (!User::find($r->id)) {
            return redirect()->back()->with('failed', 'Data tidak ditemukan');
        }

        $user = User::find($r->id);
        $user->active = $r->status;
        $user->updated_by = Auth::user()->id;

        if ($user->save()) {
            return redirect()->back()->with('success', 'Berhasil disimpan');
        } else {
            return redirect()->back()->with('failed', 'Gagal disimpan');
        }
    }

    function delete($id)
    {
        if (!User::find($id)) {
            return redirect()->back()->with('failed', 'Data tidak ditemukan');
        }

        if (User::find($id)->delete()) {
            return redirect()->back()->with('success', 'Berhasil dihapus');
        } else {
            return redirect()->back()->with('failed', 'Gagal dihapus');
        }
    }
}
