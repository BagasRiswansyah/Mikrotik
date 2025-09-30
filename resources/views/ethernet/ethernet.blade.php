@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Interfaces</div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(empty($data))
            <div class="alert alert-danger">Tidak bisa mengambil data dari Mikrotik.</div>
        @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>MAC Address</th>
                    <th>Running</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item['.id'] ?? '-' }}</td>
                    <td>{{ $item['name'] ?? '-' }}</td>
                    <td>{{ $item['mac-address'] ?? '-' }}</td>
                    <td>
                        @if($item['running'] === 'true')
                            <span class="badge bg-success">Running</span>
                        @else
                            <span class="badge bg-danger">Stopped</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('ethernet.toggle', $item['.id']) }}" method="POST">
                            @csrf
                            @if($item['disabled'] === 'true')
                                <button type="submit" class="btn btn-sm btn-success">Enable</button>
                            @else
                                <button type="submit" class="btn btn-sm btn-danger">Disable</button>
                            @endif
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
