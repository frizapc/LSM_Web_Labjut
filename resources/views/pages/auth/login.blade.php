@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-purple text-white text-center py-3">
                    <h4 class="mb-0">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login ke Sistem
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('authenticate') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label text-purple">Username</label>
                            <input id="username" type="text" 
                                class="form-control @error('username') is-invalid @enderror" 
                                name="username" value="{{ old('username') }}" 
                                autocomplete="username" autofocus>

                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-purple">Password</label>
                            <div class="input-group">
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       autocomplete="current-password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                </button>
    
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-purple">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Login
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a href="{{ route('password.request') }}" class="text-purple">
                                    Lupa Password?
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-purple">Daftar disini</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/login.min.js') }}"></script>
@endpush