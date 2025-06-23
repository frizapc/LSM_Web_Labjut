@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-purple text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-4">1,234</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-purple text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text display-4">567</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-purple text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text display-4">$12,345</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection