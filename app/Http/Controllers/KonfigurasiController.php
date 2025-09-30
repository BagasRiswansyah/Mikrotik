<?php

namespace App\Http\Controllers;

use App\Models\Konfigurasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KonfigurasiController extends Controller
{
    public function index()
    {
        $data = Konfigurasi::all();
        return view('konfigurasi', compact('data'));
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'ip_address' => 'required|ip',
        'role' => 'required|in:admin,guru',
        'password' => 'required|min:4',
        'is_active' => 'nullable'
    ]);

    Konfigurasi::create([
        'ip_address' => $validated['ip_address'],
        'role' => $validated['role'],
        'password' => Hash::make($validated['password']),
        'is_active' => $request->has('is_active') ? 1 : 0
    ]);

    return redirect()->route('konfigurasi.index')->with('success', 'Data berhasil ditambahkan');
}

    public function edit($id)
    {
    $konfigurasi = Konfigurasi::findOrFail($id);
    return view('konfigurasi_edit', compact('konfigurasi'));
    }


    public function update(Request $request, Konfigurasi $konfigurasi)
    {
    if ($request->has('action') && $request->action === 'toggle_status') {
        $konfigurasi->update([
            'is_active' => $request->is_active
        ]);
        return redirect()->route('konfigurasi.index')->with('success', 'Status berhasil diubah');
    }

    $request->validate([
        'ip_address' => 'required|ip',
        'role' => 'required|in:admin,guru',
    ]);

    $konfigurasi->update([
        'ip_address' => $request->ip_address,
        'role' => $request->role,
        'is_active' => $request->has('is_active') ? 1 : 0,
    ]);

    return redirect()->route('konfigurasi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Konfigurasi $konfigurasi)
    {
        $konfigurasi->delete();
        return redirect()->route('konfigurasi.index')->with('success', 'Data berhasil dihapus');
    }
}
