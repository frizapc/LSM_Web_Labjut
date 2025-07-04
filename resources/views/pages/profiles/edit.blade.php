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
                             alt="Current Photo" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    
                    <input type="file" class="form-control border-purple @error('photo') is-invalid @enderror" 
                           id="photo" name="photo" accept="image/*">
                    <div class="form-text text-muted">Format: JPG, PNG (Maksimal 1MB)</div>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Preview Foto Baru -->
                    <div class="mt-2">
                        <img id="image-preview" src="#" alt="Preview" class="img-thumbnail rounded-circle d-none" 
                             style="width: 150px; height: 150px; object-fit: cover;">
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

<script>
    // Preview gambar sebelum upload
    document.getElementById('photo').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const file = e.target.files[0];
        
        if (file) {
            // Tampilkan label preview
            const previewLabel = document.createElement('p');
            previewLabel.className = 'small text-muted mt-2';
            previewLabel.textContent = 'Preview Foto Baru:';
            preview.parentNode.insertBefore(previewLabel, preview);
            
            // Validasi ukuran file
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                this.value = '';
                return;
            }
            
            // Tampilkan preview
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
        }
    });
</script>
@endsection