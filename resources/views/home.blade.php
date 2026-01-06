@extends('layouts.app')

@section('content')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection
<div class="app-content">
    <div class="container-fluid">
       <x-dashboard-cards/>
    </div>
</div>
@endsection
