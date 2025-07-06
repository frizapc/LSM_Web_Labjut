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
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Terdapat kesalahan! {{ session('error') }}</strong>
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
                               id="name" name="name" value="{{ old('name', $exam->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="duration" class="form-label text-purple">Durasi (menit)</label>
                        <input type="number" class="form-control border-purple @error('duration') is-invalid @enderror" 
                               id="duration" name="duration" value="{{ old('duration', $exam->duration) }}">
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
                            {{ $exam->is_active ? 'checked' : '' }}>
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

    <div class="card shadow border-0 mt-4">
        <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-journal-plus me-2"></i>Daftar Soal
            </h5>
            <form action="{{ route('courses.exams.questions.store', [$course->id, $exam->id]) }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-light-purple" type="submit">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Soal
                </button>
            </form>
        </div>
        
        <div class="card-body">
            @if($exam->questions->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-journal-x text-purple" style="font-size: 3rem;"></i>
                    <h5 class="text-purple mt-3">Belum ada soal tersedia</h5>
                </div>
            @else
                <div class="accordion" id="questionsAccordion">
                    @foreach($exam->questions as $question)
                    <div class="accordion-item border-purple-light mb-3">
                        <h2 class="accordion-header" id="heading{{ $question->id }}">
                            <button class="accordion-button collapsed bg-purple-light text-purple" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapse{{ $question->id }}" 
                                    aria-expanded="false" 
                                    aria-controls="collapse{{ $question->id }}">
                                Soal #{{ $loop->iteration }}
                            </button>
                        </h2>
                        <div id="collapse{{ $question->id }}" 
                            class="accordion-collapse collapse" 
                            aria-labelledby="heading{{ $question->id }}" 
                            data-bs-parent="#questionsAccordion">
                            <div class="accordion-body">
                                <form action="{{ route('courses.exams.questions.update', [$course->id, $exam->id, $question->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label class="form-label text-purple">Pertanyaan</label>
                                        <textarea class="form-control border-purple" 
                                                name="question_text" 
                                                rows="3">{{ $question->question_text }}</textarea>
                                    </div>
                                    
                                    <div class="options-container">
                                        <label class="form-label text-purple">Opsi Jawaban</label>
                                        @foreach($question->options as $option)
                                        <div class="input-group mb-2">
                                            <div class="input-group-text bg-white">
                                                <input class="form-check-input mt-0" 
                                                type="radio" 
                                                name="correct_option" 
                                                value="{{ $option->id }}"
                                                {{ $option->is_correct ? 'checked' : '' }}>
                                            </div>
                                            <input type="text" 
                                                class="form-control border-purple" 
                                                name="{{ $option->id }}" 
                                                value="{{ $option->option_text }}">
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mt-3">
                                        <button type="submit" class="btn btn-sm btn-purple">
                                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete([
                                                    '{{ $course->id }}',
                                                    '{{ $exam->id  }}',
                                                    '{{ $question->id }}',
                                                ])">
                                            <i class="bi bi-trash me-1"></i> Hapus Soal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteQuestionForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<style>
    .form-check-input:checked {
        background-color: #6a0dad;
        border-color: #6a0dad;
    }
    .bg-purple-light {
        background-color: rgba(106, 13, 173, 0.1);
    }
    .border-purple-light {
        border-color: rgba(106, 13, 173, 0.2);
    }
    .accordion-button:not(.collapsed) {
        background-color: rgba(106, 13, 173, 0.2);
        color: #6a0dad;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isActiveCheckbox = document.getElementById('is_active');
        isActiveCheckbox.addEventListener('change', function() {
            this.value = this.checked ? '1' : '0';
        });
    });

    function confirmDelete(ids) {
        if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
            const form = document.getElementById('deleteQuestionForm');
            form.action = `/courses/${ids[0]}/exams/${ids[1]}/questions/${ids[2]}`;
            form.submit();
        }
    }
</script>

@endsection
