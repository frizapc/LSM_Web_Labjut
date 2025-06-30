@extends('layouts.app')

@section('title', $exam->name)

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0 h-100">
        <div class="card-header bg-purple text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-journal-text me-2"></i>Nomer {{ $questions->currentPage() }}
                </h5>
                <div class="d-flex align-items-center">
                    <span class="badge bg-light fs-6 text-black me-2">
                        <i class="bi bi-clock me-1"></i> {{ $exam->duration }} menit
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
                              <div class="alphabet-section d-flex rounded-circle align-items-center m-3"  style="width: 30px; height: 30px;">
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
                            <a href="{{ $questions->previousPageUrl() }}" class="btn btn-outline-purple">
                                <i class="bi bi-chevron-left me-1"></i> Sebelumnya
                            </a>
                        @else
                            <span></span> <!-- Spacer -->
                        @endif

                        @if($questions->currentPage() < $questions->lastPage())
                            <button type="submit" name="action" value="{{ $questions->nextPageUrl() }}" class="btn btn-purple">
                                Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                            </button>
                        @else
                            <button type="submit" name="action" value="finish" class="btn btn-danger">
                                <i class="bi bi-stop-circle me-1"></i> Selesaikan Ujian
                            </button>
                        @endif
                    </div>
                </form>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-journal-x text-purple" style="font-size: 3rem;"></i>
                    <h5 class="text-purple mt-3">Belum ada soal tersedia</h5>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
  .question-card {
      background-color: rgba(106, 13, 173, 0.05);
      border-color: rgba(106, 13, 173, 0.2);
  }
  .form-check-input:checked {
      background-color: #6a0dad;
      border-color: #6a0dad;
  }
  .progress-bar {
      transition: width 0.3s ease;
  }
  .option-item {
      margin-bottom: 1rem;
  }
  .option-item label {
      display: flex;
      align-items: center;
      padding: 1rem;
      border: 2px solid #dee2e6;
      border-radius: 0.5rem;
      cursor: pointer;
  }
  .option-letter {
      font-weight: bold;
      color: #6a0dad;
      margin-right: 1rem;
      font-size: 1.2rem;
  }
  input:checked + label {
      background-color: #6a0dad;
      color: #dee2e6;
      font-weight: bold;
  }
  .form-check.selected .alphabet-section {
    background-color: #6a0dad;
    color: white;
  }
</style>

<script>
  document.querySelectorAll('input[type="radio"][name="answer"]').forEach((radio) => {
      radio.addEventListener('change', () => {
          document.querySelectorAll('.form-check').forEach((el) => el.classList.remove('selected'));
          if (radio.checked) {
              radio.closest('.form-check').classList.add('selected');
          }
      });
  });
</script>

@endsection