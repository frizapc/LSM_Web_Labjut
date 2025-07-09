@extends('layouts.app')

@section('title', 'Edit Materi')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0" style="min-height: 500px; overflow-y: auto;">
        <div class="card-header bg-purple text-white">
            <h5 class="mb-0">
                <i class="bi bi-pencil-square me-2"></i>Edit Materi {{ $material->name }}
            </h5>
        </div>
        
        <div class="card-body">
            <form action="{{ route('courses.materials.update', [$course->id, $material->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label text-purple">Nama Materi</label>
                        <input type="text" class="form-control border-purple @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $material->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label text-purple">Deskripsi (opsional)</label>
                    <textarea class="form-control border-purple @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $material->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="source" class="form-label text-purple">File Materi (PDF)</label>
                    
                    @if($material->source)
                    <div class="alert alert-purple-light border-purple-light mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-file-earmark-pdf text-purple me-2"></i>
                                <span>File saat ini:</span>
                            </div>
                            <a href="{{ asset('storage/'.$material->source) }}" target="_blank" class="btn btn-sm btn-purple">
                                <i class="bi bi-eye me-1"></i> Lihat
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    <input type="file" class="form-control border-purple @error('source') is-invalid @enderror" 
                           id="source" name="source" accept=".pdf">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
                    @error('source')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mt-3">
                        <iframe id="pdf-preview" src="#" class="w-100 d-none" style="height: 500px; border: 1px solid #dee2e6;"></iframe>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <div>
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-purple me-2">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-purple">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript untuk preview PDF dan konfirmasi hapus -->
<script>
    // Preview PDF
    document.getElementById('source').addEventListener('change', function(e) {
        const preview = document.getElementById('pdf-preview');
        const file = e.target.files[0];
        
        if (file && file.type === 'application/pdf') {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
            if (file) alert('Hanya file PDF yang diperbolehkan');
        }
    });

    // Konfirmasi hapus
    function confirmDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus materi ini?')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>

<style>
    .alert-purple-light {
        background-color: rgba(106, 13, 173, 0.1);
        border-color: rgba(106, 13, 173, 0.2);
    }
    .border-purple-light {
        border-color: rgba(106, 13, 173, 0.2);
    }
</style>
@endsection