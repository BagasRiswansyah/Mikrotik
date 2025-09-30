@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">White List</div>
    <div class="card-body">

        {{-- Notif sukses/error --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Form Tambah Domain --}}
        <form action="{{ route('addresslist.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <input type="text" name="address" class="form-control" placeholder="Domain / IP" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="comment" class="form-control" placeholder="contoh: www.detik.com">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>

        <form action="{{ route('addresslist.index') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-5">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari domain/IP...">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary">Cari</button>
                </div>
            </div>
        </form>

        {{-- Tabel White List --}}
        @if(empty($data))
            <div class="alert alert-danger">Tidak bisa mengambil data dari Mikrotik.</div>
        @else
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Domain / IP</th>
                        <th>Disabled</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['address'] ?? '-' }}</td>
                            <td>
                                @if(($item['disabled'] ?? 'false') === 'true')
                                    <span class="badge bg-danger">Disabled</span>
                                @else
                                    <span class="badge bg-success">Enabled</span>
                                @endif
                            </td>
                            <td>{{ $item['comment'] ?? '-' }}</td>
                            <td>
                                {{-- Tombol Enable / Disable --}}
                                @if(($item['disabled'] ?? 'false') === 'false')
                                    <form action="{{ route('addresslist.disable', $item['.id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm">Disable</button>
                                    </form>
                                @else
                                    <form action="{{ route('addresslist.enable', $item['.id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">Enable</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- Tabel History --}}
        <div class="mt-5">
            <h5>Histori Pengimputan</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Aksi</th>
                            <th>Domain/IP</th>
                            <th>Comment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $history->user->name ?? 'Unknown' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $history->user_role }}</span>
                                </td>
                                <td>
                                    @if($history->action == 'CREATE')
                                        <span class="badge bg-success">Tambah</span>
                                    @elseif($history->action == 'UPDATE')
                                        <span class="badge bg-warning">Update</span>
                                    @elseif($history->action == 'DELETE')
                                        <span class="badge bg-danger">Hapus</span>
                                    @elseif($history->action == 'ENABLE')
                                        <span class="badge bg-primary">Enable</span>
                                    @elseif($history->action == 'DISABLE')
                                        <span class="badge bg-secondary">Disable</span>
                                    @endif
                                </td>
                                <td>{{ $history->domain_ip }}</td>
                                <td>{{ $history->comment ?? '-' }}</td>
                                <td>
                                    @if($history->status === 'enabled')
                                        <span class="badge bg-success">Enabled</span>
                                    @else
                                        <span class="badge bg-danger">Disabled</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data history</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if($histories->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $histories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection