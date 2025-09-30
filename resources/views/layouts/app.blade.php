<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Mikrotik') }}</title>

    {{-- <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="30">
    </a> --}}

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #f8f9fa;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
            background: #343a40;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            margin: 0.2rem 0;
            border-radius: 5px;
            display: block;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            flex: 1;
            padding: 1rem;
        }
    </style>
</head>
<body>
    @auth
    {{-- Jika user sudah login, tampilkan sidebar --}}
    <div class="wrapper">
        <div class="sidebar">
            <h4 class="mb-4">{{ config('app.name', 'Mikrotik') }}</h4>
            <a href="{{ url('/home') }}"> Home</a>
            <a href="{{ url('/konfigurasi') }}"> Konfigurasi</a>
            <a href="{{ url('/ethernet') }}"> Interface</a>
            <a class="nav-link" href="{{ route('addresslist.index') }}">White List</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background:none;border:none;color:white;text-align:left;padding:0.5rem 1rem;margin-top:auto;"> Logout</button>
            </form>
        </div>
        <div class="content">
            <main>
                @yield('content')
            </main>
        </div>
    </div>
    @endauth
    @guest
    <div class="container mt-5">
        @yield('content')
    </div>
    @endguest
</body>
</html>
