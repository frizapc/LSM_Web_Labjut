@extends('layouts.app')

@section('title', 'Edit Ujian')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow border-0" style="min-height: 200px; overflow-y: auto;">
        <div class="card-header bg-purple text-white">
            <h5 class="mb-0">
                <i class="bi bi-pencil-square me-2"></i>Edit Ujian {{ $exam->name }}
            </h5>
        </div>
        
        <div class="card-body">
            <form action="{{ route('courses.exams.update', [$course->id, $exam->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="name" class="form-label text-purple">Nama Ujian</label>
                        <input type="text" class="form-control border-purple @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $exam->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="duration" class="form-label text-purple">Durasi (menit)</label>
                        <input type="number" class="form-control border-purple @error('duration') is-invalid @enderror" 
                               id="duration" name="duration" value="{{ old('duration', $exam->duration) }}" 
                               min="1" required>
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="mb-3">
                    <label for="note" class="form-label text-purple">Catatan (Opsional)</label>
                    <textarea class="form-control border-purple @error('note') is-invalid @enderror" 
                            id="note" name="note" rows="1">{{ old('note', $exam->note) }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                            {{ old('is_active', $exam->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label text-purple" for="is_active">Aktifkan Ujian</label>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
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

<style>
    .form-check-input:checked {
        background-color: #6a0dad;
        border-color: #6a0dad;
    }
</style>
@endsection