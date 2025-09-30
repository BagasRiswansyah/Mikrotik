<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EthernetController extends Controller
{
    public function index()
    {
        try {
            $response = Http::timeout(10)
                ->withBasicAuth('web', '12345678')
                ->get('http://192.168.10.1/rest/interface');

            $data = $response->json();
            return view('ethernet.ethernet', compact('data'));
        } catch (\Exception $e) {
            return view('ethernet.ethernet', ['data' => []]);
        }
    }

    public function toggle($id)
    {
        try {
            // Ambil data interface dulu
            $response = Http::timeout(10)
                ->withBasicAuth('web', '12345678')
                ->get("http://192.168.10.1/rest/interface/$id");

            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengambil data interface');
            }

            $interface = $response->json();
            $disabled = $interface['disabled'] ?? 'false';

            // Tentukan status baru (toggle)
            $newStatus = ($disabled === 'true') ? 'false' : 'true';

            // Kirim request update
            $update = Http::timeout(10)
                ->withBasicAuth('web', '12345678')
                ->put("http://192.168.10.1/rest/interface/$id", [
                    'disabled' => $newStatus
                ]);

            if (!$update->successful()) {
                return back()->with('error', 'Gagal mengubah status interface');
            }

            return redirect()->route('ethernet.index')->with('success', 'Status interface berhasil diubah!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
