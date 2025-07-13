@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-person-gear me-2"></i>Edit Profil
            </h5>
        </div>
        
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control border-purple @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ auth()->user()->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control border-purple @error('username') is-invalid @enderror" 
                               id="username" name="username" value="{{ auth()->user()->username }}">
                        @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Mohon username dicatat</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label text-purple">Foto Profil</label>
                    
                    <!-- Preview Foto Sebelumnya -->
                    <div class="mb-2">
                        <p class="small text-muted">Foto Saat Ini:</p>
                        <img src="{{ auth()->user()->photo ? Storage::url(auth()->user()->photo) : asset('images/default-profile.jpg') }}" 
                             alt="Current Photo" class="img-thumbnail rounded-circle">
                    </div>
                    
                    <input type="file" class="form-control border-purple @error('photo') is-invalid @enderror" 
                           id="photo" name="photo" accept="image/*">
                    <div class="form-text text-muted">Maksimal 1MB</div>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Preview Foto Baru -->
                    <div class="mt-2">
                        <img id="image-preview" src="#" alt="Preview" class="img-thumbnail rounded-circle d-none">
                    </div>
                </div>
                
                <div class="d-flex justify-content-end align-items-center">
                    <a href="/" class="btn btn-outline-purple">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <div>
                        <button type="submit" class="btn btn-purple">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profiles-edit.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/profiles-edit.min.js') }}"></script>
@endpush