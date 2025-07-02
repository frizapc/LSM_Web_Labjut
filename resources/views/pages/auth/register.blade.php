@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-purple text-white text-center py-3">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>
                        Daftar Akun Baru
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('store.user') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label text-purple">Nama Lengkap</label>
                            <input id="name" type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}" 
                                autocomplete="name" autofocus>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label text-purple">Username</label>
                            <input id="username" type="text" 
                                class="form-control @error('username') is-invalid @enderror" 
                                name="username" value="{{ old('username') }}" 
                                autocomplete="username">

                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-purple">Password</label>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password"  
                                   autocomplete="new-password">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label text-purple">Konfirmasi Password</label>
                            <input id="password-confirm" type="password" 
                                   class="form-control" 
                                   name="password_confirmation"  
                                   autocomplete="new-password">
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-purple">
                                <i class="bi bi-person-plus me-1"></i>
                                Daftar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-purple">Login disini</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style konsisten dengan login page */
    .card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
    }
    
    .card-header {
        border-bottom: none;
    }
    
    .form-control {
        border: 1px solid rgba(106, 13, 173, 0.3);
        padding: 10px 15px;
    }
    
    .form-control:focus {
        border-color: var(--purple-primary);
        box-shadow: 0 0 0 0.25rem rgba(106, 13, 173, 0.25);
    }
    
    .btn-purple {
        background-color: var(--purple-primary);
        border: none;
        padding: 10px;
        font-weight: 500;
        color: white;
    }
      
    .btn-purple:hover {
        background-color: var(--purple-dark);
        color: white;
    }
    
    .text-purple {
        color: black;
    }
</style>
@endsection