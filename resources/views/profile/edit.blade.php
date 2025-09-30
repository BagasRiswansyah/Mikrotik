@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Profil User</div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Update Profil --}}
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control">
            </div>
            <div class="mb-3">
                <label>Foto Profil</label><br>
                @if($user->photo)
                    <img src="{{ asset('storage/'.$user->photo) }}" alt="Foto" width="80" class="mb-2"><br>
                @endif
                <input type="file" name="photo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update Profil</button>
        </form>

        <hr>

        {{-- Update Password --}}
        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button type="submit" class="btn btn-warning">Ganti Password</button>
        </form>
        <hr>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>
@endsection
