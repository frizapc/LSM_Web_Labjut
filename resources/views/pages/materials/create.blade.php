@extends('layouts.app')

@section('title', 'Tambah Materi Baru')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0"   >
        <div class="card-header bg-purple text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle me-2"></i>Tambah Materi {{ $course->name }}
            </h5>
        </div>
        
        <div class="card-body">
            <form action="{{ route('courses.materials.store', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label text-purple">Nama Materi</label>
                        <input type="text" class="form-control border-purple @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label text-purple">Deskripsi (opsional)</label>
                    <textarea class="form-control border-purple @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="source" class="form-label text-purple">File Materi (PDF)</label>
                    <input type="file" class="form-control border-purple @error('source') is-invalid @enderror" 
                           id="source" name="source" accept=".pdf">
                    @error('source')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mt-3">
                        <iframe id="pdf-preview" src="#" class="w-100 d-none"></iframe>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-purple me-2">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-purple">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/materials-create.min.js') }}"></script>
@endpush