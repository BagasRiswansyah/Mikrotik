@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Edit Konfigurasi</div>
    <div class="card-body">
        <form method="POST" action="{{ route('konfigurasi.update', $konfigurasi->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">IP Address</label>
                <input type="text" name="ip_address" value="{{ $konfigurasi->ip_address }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">User Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $konfigurasi->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru" {{ $konfigurasi->role == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Isi jika ingin ganti password">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input"
                    {{ $konfigurasi->is_active ? 'checked' : '' }}>
                <label class="form-check-label">Aktif</label>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('konfigurasi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
