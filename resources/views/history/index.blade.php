@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Histori Aktivitas</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Target</th>
                    <th>Tanggal & Jam</th>
                </tr>
            </thead>
            <tbody>
                @foreach($histories as $h)
                    <tr>
                        <td>{{ $h->user_name }}</td>
                        <td>{{ $h->action }}</td>
                        <td>{{ $h->target }}</td>
                        <td>{{ $h->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
