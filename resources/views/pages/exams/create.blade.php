@extends('layouts.app')

@section('title', 'Tambah Ujian Baru')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0" style="min-height: 200px; overflow-y: auto;">
        <div class="card-header bg-purple text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle me-2"></i>Tambah Ujian {{ $course->name }}
            </h5>
        </div>
        
        <div class="card-body">
            <form action="{{ route('courses.exams.store', $course->id) }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label text-purple">Nama Ujian</label>
                        <input type="text" class="form-control border-purple @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-8">
                        <label for="note" class="form-label text-purple">Catatan (Opsional)</label>
                        <textarea class="form-control border-purple @error('note') is-invalid @enderror" 
                                id="note" name="note" rows="1">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

<style>
    .form-check-input:checked {
        background-color: #6a0dad;
        border-color: #6a0dad;
    }
</style>
@endsection