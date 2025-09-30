@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Konfigurasi</div>
    <div class="card-body">
        {{-- Notif sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- FORM TAMBAH DATA --}}
        <form method="POST" action="{{ route('konfigurasi.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">IP Address</label>
                <input type="text" name="ip_address" class="form-control" placeholder="Ketik alamat ip anda" required>
            </div>

            <div class="mb-3">
                <label class="form-label">User Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="guru">Guru</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password anda" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" checked>
                <label class="form-check-label" for="isActive">Aktif</label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        {{-- TABLE DATA --}}
        @if(isset($data) && $data->count())
        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>

                    <th>IP Address</th>
                    <th>Role</th>
                    <th>Is Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>

                    <td>{{ $item->ip_address }}</td>
                    <td>{{ ucfirst($item->role) }}</td>
                    <td>{{ $item->is_active ? 'true' : 'false' }}</td>
                    <td>
                        <a href="{{ route('konfigurasi.edit', $item->id) }}" class="btn btn-sm">Edit</a>
                        <form action="{{ route('konfigurasi.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" onclick="return confirm('Hapus data ini?')"> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p class="mt-3 text-muted">Belum ada data konfigurasi.</p>
        @endif
    </div>
</div>
@endsection
