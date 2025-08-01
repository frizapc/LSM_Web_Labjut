@extends('layouts.app')

@section('title', $exam->name)

@section('content')
<div class="container-fluid py-4">
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow border-0 h-100">
        <div class="card-header bg-purple text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-journal-text me-2"></i>Nomer {{ $questions->currentPage() }}
                </h5>
                <div class="d-flex align-items-center">
                    <span class="badge bg-light fs-6 text-black me-2">
                        <i class="bi bi-clock me-1"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if($questions->count() > 0)
                <form class="h-100" action="{{ route('courses.exams.submit', [$course->id, $exam->id]) }}" method="POST">
                    @csrf
                    
                    <!-- Question Card -->
                    <div class="question-card mb-4 p-4 border rounded">
                        <p class="fs-5 mb-0">{{ $questions[0]->question_text }}</p>

                        <!-- Options -->
                        <div class="options-container h-75 d-flex row gap-4 py-5">
                            @php
                                $alphabet = range('A', 'D');
                            @endphp
                            @foreach($questions[0]->options as $index => $option)
                            <div class="form-check p-0 mb-0 d-flex justify-between align-items-center border border-opacity-75 border-secondary rounded-2"> 
                              <div class="alphabet-section d-flex rounded-circle align-items-center m-3">
                                  <span class="fw-bold mx-auto">{{ $alphabet[$index] }}</span>
                              </div>
                              <input 
                              class="visually-hidden" 
                              type="radio" 
                              name="answer"
                              value="{{ $option->id }}"
                              id="option_{{ $option->id }}">
                              <label class="form-check-label flex-grow-1 d-flex align-items-center px-2 h-100" for="option_{{ $option->id }}"> 
                                  {{ $option->option_text }}
                              </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigation & Submit -->
                    <div class="d-flex justify-content-between mt-4">
                        @if($questions->currentPage() > 1)
                            <a href="{{ $questions->previousPageUrl() }}" class="btn btn-purple">
                                <i class="bi bi-chevron-left ms-1"></i>
                                Sebelumnya
                            </a>
                        @else
                            <span></span>
                        @endif

                        @if($questions->currentPage() < $questions->lastPage())
                            <a href="{{ $questions->nextPageUrl() }}" class="btn btn-purple">
                                Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                            </a>
                        @else
                            <button id="finish-btn" type="button" class="btn btn-danger">
                                <i class="bi bi-stop-circle me-1"></i> AKhiri Ujian
                            </button>
                        @endif
                    </div>
                </form>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-journal-x text-purple"></i>
                    <h5 class="text-purple mt-3">Belum ada soal tersedia</h5>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/exams-show.min.css') }}">
@endpush

@push('scripts')
<script>
    window._APP_DATA = {
        courseId: "{{ $course->id }}",
        examId: "{{ $exam->id }}",
        currentPage: "{{ $questions->currentPage() }}",
        csrfToken: "{{ csrf_token() }}",
        timeLeft: "{{ $timeLeft }}",
        submitUrl: "{{ route('courses.exams.submit', [$course->id, $exam->id]) }}",
        finishUrl: "{{ route('courses.exams.finish', [$course->id, $exam->id]) }}"
    };
</script>
<script src="{{ asset('js/exams-show.min.js') }}"></script>
@endpush