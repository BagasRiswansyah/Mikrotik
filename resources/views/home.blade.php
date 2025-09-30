@extends('layouts.app')
@section('content')
<style>
    body{
        background url: ;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Login telah berhasil!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
