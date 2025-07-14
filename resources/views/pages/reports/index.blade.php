@extends('layouts.app')

@section('title', 'Laporan Hasil Ujian')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-purple text-white">
            <h5 class="mb-0">
                <i class="bi bi-bar-chart-line me-2"></i>Laporan Hasil Ujian
            </h5>
        </div>
        
        <div class="card-body">
            @if($courses->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-journal-x text-purple"></i>
                    <h5 class="text-purple mt-3">Belum ada data laporan</h5>
                </div>
            @else
                <div class="accordion" id="coursesAccordion">
                    @foreach($courses as $course)
                    <div class="accordion-item border-purple-light mb-3">
                        <h2 class="accordion-header" id="courseHeading{{ $course->id }}">
                            <button class="accordion-button collapsed bg-purple-light text-purple" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#courseCollapse{{ $course->id }}" 
                                    aria-expanded="false" 
                                    aria-controls="courseCollapse{{ $course->id }}">
                                {{ $course->name }} ({{ $course->exams->count() ?? 0 }} Ujian)
                            </button>
                        </h2>
                        <div id="courseCollapse{{ $course->id }}" 
                            class="accordion-collapse collapse" 
                            aria-labelledby="courseHeading{{ $course->id }}" 
                            data-bs-parent="#coursesAccordion">
                            <div class="accordion-body">
                                @if($course->exams->isEmpty())
                                    <div class="alert alert-info">
                                        Tidak ada ujian untuk kursus ini
                                    </div>
                                @else
                                    <div class="accordion" id="examsAccordion{{ $course->id }}">
                                        @foreach($course->exams as $exam)
                                        <div class="accordion-item border-purple-light mb-2">
                                            <h2 class="accordion-header" id="examHeading{{ $exam->id }}">
                                                <button class="accordion-button collapsed bg-purple-light text-purple" 
                                                        type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#examCollapse{{ $exam->id }}" 
                                                        aria-expanded="false" 
                                                        aria-controls="examCollapse{{ $exam->id }}">
                                                    {{ $exam->name }} ({{ $exam->scores_count }} Peserta)
                                                </button>
                                            </h2>
                                            <div id="examCollapse{{ $exam->id }}" 
                                                class="accordion-collapse collapse" 
                                                aria-labelledby="examHeading{{ $exam->id }}" 
                                                data-bs-parent="#examsAccordion{{ $course->id }}">
                                                <div class="accordion-body">
                                                    @if($exam->scores->isEmpty())
                                                        <div class="alert alert-info">
                                                            Belum ada peserta yang mengikuti ujian ini
                                                        </div>
                                                    @else
                                                        <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr class="bg-purple text-white">
                                                                        <th>No</th>
                                                                        <th>Nama Peserta</th>
                                                                        <th>Nilai</th>
                                                                        <th>Diselesaikan</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($exam->scores as $score)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $score->user->name }}</td>
                                                                        <td>
                                                                            <span class="badge bg-{{ $score->score >= 75 ? 'success' : ($score->score >= 50 ? 'warning' : 'danger') }}">
                                                                                {{ $score->score }}
                                                                            </span>
                                                                        </td>
                                                                        <td>{{ $score->created_at->diffForHumans() }}</td>
                                                                        <td>
                                                                            <a href="#" class="btn btn-sm btn-purple">
                                                                                <i class="bi bi-eye"></i> Detail
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reports-index.min.css') }}">
@endpush