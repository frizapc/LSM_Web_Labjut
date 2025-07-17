@extends('layouts.app')

@section('title', 'Edit Kursus')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-pencil-square me-2"></i>Edit Kursus
            </h5>
            <span class="badge bg-light fs-6 text-dark">{{ $course->code }}</span>
        </div>
        
        <div class="card-body">
            <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label text-purple">Nama Kursus</label>
                        <input type="text" class="form-control border-purple @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $course->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="level" class="form-label text-purple">Level</label>
                        <select class="form-select border-purple @error('level') is-invalid @enderror" 
                                id="level" name="level">
                            <option value="" disabled>Pilih Level</option>
                            <option value="Pemula" {{ old('level', $course->level) == 'Pemula' ? 'selected' : '' }}>Pemula</option>
                            <option value="Menengah" {{ old('level', $course->level) == 'Menengah' ? 'selected' : '' }}>Menengah</option>
                            <option value="Mahir" {{ old('level', $course->level) == 'Mahir' ? 'selected' : '' }}>Mahir</option>
                        </select>
                        @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label text-purple">Deskripsi</label>
                    <textarea class="form-control border-purple @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ $course->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="photo" class="form-label text-purple">Foto Kursus</label>
                    
                    <!-- Preview Foto Sebelumnya -->
                    <div class="mb-2">
                        <p class="small text-muted">Foto Saat Ini:</p>
                        <img src="{{ Storage::url($course->photo) }}" alt="Current Photo" class="img-thumbnail">
                    </div>
                    
                    <input type="file" class="form-control border-purple @error('photo') is-invalid @enderror" 
                           id="photo" name="photo" accept="image/*">
                    <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</div>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Preview Foto Baru -->
                    <div class="mt-2">
                        <img id="image-preview" src="#" alt="Preview" class="img-thumbnail d-none">
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-purple me-2">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-purple">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/courses-edit.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/courses-edit.min.js') }}"></script>
@endpush