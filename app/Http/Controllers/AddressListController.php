<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AddressListHistory;
use Illuminate\Support\Facades\Auth;

class AddressListController extends Controller
{
    public function index(Request $request)
    {
        try {
            $host = config('services.mikrotik.host');
            $user = config('services.mikrotik.user');
            $pass = config('services.mikrotik.pass');
            $response = Http::timeout(10)
                ->withBasicAuth($user, $pass)
                ->get("$host/rest/ip/firewall/address-list");

            $data = $response->json();

            // Filter kalau ada pencarian
            if ($request->filled('search')) {
                $search = strtolower($request->search);
                $data = array_filter($data, function ($item) use ($search) {
                    return isset($item['address']) && str_contains(strtolower($item['address']), $search);
                });
            }

            // Ambil data history
            $histories = AddressListHistory::with('user')
                ->latest()
                ->take(50) // Ambil 50 data terbaru
                ->get();

            return view('addresslist.addresslist', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $host = config('services.mikrotik.host');
            $user = config('services.mikrotik.user');
            $pass = config('services.mikrotik.pass');
            Http::timeout(10)
            ->withBasicAuth($user, $pass)
            ->withBody(json_encode([
                'list' => 'allowed',
                'address' => "www." . $request->address,
                'comment' => $request->comment,
                'disabled' => 'false',
            ]), 'application/json')
            ->put("$host/rest/ip/firewall/address-list");

            Http::timeout(10)
                ->withBasicAuth($user, $pass)
                ->withBody(json_encode([
                    'list' => 'allowed',
                    'address' => $request->address,
                    'comment' => $request->comment,
                    'disabled' => 'false',
                ]), 'application/json')
                ->put("$host/rest/ip/firewall/address-list");

            // Simpan history
            AddressListHistory::create([
                'action' => 'CREATE',
                'domain_ip' => $request->address,
                'comment' => $request->comment,
                'status' => 'enabled',
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role ?? 'user' // Sesuaikan dengan field role di model User
            ]);

            return redirect()->route('addresslist.index')
                ->with('success', 'Domain/IP berhasil ditambahkan ke Mikrotik!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan: '.$e->getMessage());
        }
    }
    
    // public function toggle($id)
    // {
    //     try {
    //         $response = Http::timeout(10)
    //             ->withBasicAuth('web', '12345678')
    //             ->get("http://192.168.10.1/rest/ip/firewall/address-list/$id");

    //         $address = $response->json();

    //         if (!$address) {
    //             return redirect()->back()->with('error', 'Data tidak ditemukan di Mikrotik.');
    //         }

    //         $newStatus = ($address['disabled'] === 'true') ? 'false' : 'true';

    //         Http::timeout(10)
    //             ->withBasicAuth('web', '12345678')
    //             ->put("http://192.168.10.1/rest/ip/firewall/address-list/$id", [
    //                 'disabled' => $newStatus
    //             ]);

    //         return redirect()->route('addresslist.index')->with('success', 'Status address list berhasil diubah!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Gagal ubah status: ' . $e->getMessage());
    //     }
    // }
    public function disable($id)
    {
        try {
            $host = config('services.mikrotik.host');
            $user = config('services.mikrotik.user');
            $pass = config('services.mikrotik.pass');

            // Ambil data sebelum di-disable untuk logging
            $response = Http::timeout(10)
                ->withBasicAuth($user, $pass)
                ->get("$host/rest/ip/firewall/address-list/$id");
            
            $addressData = $response->json();

            Http::timeout(10)
                ->withBasicAuth($user, $pass)
                ->withBody(json_encode([
                    'disabled' => 'true',
                ]), 'application/json')
                ->patch("$host/rest/ip/firewall/address-list");

            // Simpan history
            AddressListHistory::create([
                'action' => 'DISABLE',
                'domain_ip' => $addressData['address'] ?? 'Unknown',
                'comment' => $addressData['comment'] ?? null,
                'status' => 'disabled',
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role ?? 'user'
            ]);

            return redirect()->route('addresslist.index')
                ->with('success', 'Address list berhasil di-disable!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal disable: '.$e->getMessage());
        }
    }

    public function enable($id)
    {
        try {
            $host = config('services.mikrotik.host');
            $user = config('services.mikrotik.user');
            $pass = config('services.mikrotik.pass');

            // Ambil data sebelum di-enable untuk logging
            $response = Http::timeout(10)
                ->withBasicAuth($user, $pass)
                ->get("$host/rest/ip/firewall/address-list/$id");
            
            $addressData = $response->json();

            Http::timeout(10)
                ->withBasicAuth($user, $pass)
                ->withBody(json_encode([
                    'disabled' => 'false',
                ]), 'application/json')
                ->patch("$host/rest/ip/firewall/address-list");

            // Simpan history
            AddressListHistory::create([
                'action' => 'ENABLE',
                'domain_ip' => $addressData['address'] ?? 'Unknown',
                'comment' => $addressData['comment'] ?? null,
                'status' => 'enabled',
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role ?? 'user'
            ]);

            return redirect()->route('addresslist.index')
                ->with('success', 'Address list berhasil di-enable!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal enable: '.$e->getMessage());
        }
    }
}

