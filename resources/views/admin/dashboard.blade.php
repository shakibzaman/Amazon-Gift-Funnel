@extends('adminlte::page')

@section('title', 'Dashboard')

{{-- @section('content_header')
<h1>Dashboard</h1>
@endsection --}}

@section('content')
<div class="row-background">
    <div class="row">
        <div class="col-sm-6">
            <div class="card  m-5">
                <div class="card-body">
                    <h5 class="card-title">Welcome</h5>
                    <h2 class="card-text text-success">{{ $user->name }} ( {{ $user->email }})</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card m-5">
                <div class="card-body">
                    <h5 class="card-title">Your Role is </h5>
                    <h2 class="card-text text-success">{{ $user->roles[0]['name'] ?? 'N/A' }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }} " type="text/css">
@stop