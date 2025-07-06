@extends('layouts.app')

@section('title', 'Dashboard Peserta')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-purple mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard Saya</h1>
    </div>

    <div class="row">
        <!-- Kartu Kursus Aktif -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-start-lg border-purple shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-purple mb-0">Kursus Aktif</h5>
                            <div class="display-4 fw-bold text-purple">3</div>
                            <p class="text-muted mb-0">Kursus yang sedang Anda ikuti</p>
                        </div>
                        <div class="bg-purple-light rounded p-3">
                            <i class="bi bi-book-half text-purple" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('courses.index') }}" class="text-purple d-flex align-items-center">
                        Lihat semua kursus
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Kartu Ujian Terakhir -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-start-lg border-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-warning mb-0">Ujian Terakhir</h5>
                            <div class="d-flex align-items-baseline">
                                <div class="display-4 fw-bold text-warning">85</div>
                                <span class="ms-2 text-muted">/100</span>
                            </div>
                            <p class="text-muted mb-0">Nilai ujian Pemrograman Dasar</p>
                        </div>
                        <div class="bg-warning-light rounded p-3">
                            <i class="bi bi-clipboard-data text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('reports.index') }}" class="text-warning d-flex align-items-center">
                        Lihat detail nilai
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Kartu Progress Belajar -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-start-lg border-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-success mb-0">Progress Belajar</h5>
                            <div class="display-4 fw-bold text-success">72<span class="fs-3">%</span></div>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 72%"></div>
                            </div>
                            <p class="text-muted mb-0 mt-1">Kursus Pemrograman Web</p>
                        </div>
                        <div class="bg-success-light rounded p-3">
                            <i class="bi bi-graph-up text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="#" class="text-success d-flex align-items-center">
                        Lanjutkan belajar
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Kursus Terbaru -->
    <div class="card shadow border-0 mt-4">
        <div class="card-header bg-purple text-white">
            <h5 class="mb-0"><i class="bi bi-book me-2"></i>Kursus Saya</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-purple-light">
                        <div class="card-img-top bg-purple-light" style="height: 120px; overflow: hidden;">
                            @if($course->photo)
                                <img src="{{ asset('storage/'.$course->photo) }}" class="w-100 h-100 object-fit-cover" alt="{{ $course->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 text-purple">
                                    <i class="bi bi-journal-bookmark" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-purple">{{ $course->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($course->description ?: '-', 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-{{ $course->level == 'Pemula' ? 'info' : ($course->level == 'Menengah' ? 'warning' : 'danger') }} text-purple">{{ $course->level }}</span>
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-purple">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="card shadow border-0 mt-4">
        <div class="card-header bg-purple text-white">
            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Aktivitas Terbaru</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Anda menyelesaikan materi "Pengenalan HTML"</span>
                        <small class="text-muted d-block mt-1">2 jam yang lalu</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-purple">Review</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-clipboard-check text-purple me-2"></i>
                        <span>Anda mengerjakan ujian "Pemrograman Dasar"</span>
                        <small class="text-muted d-block mt-1">Kemarin, 15:32</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-purple">Lihat Nilai</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-journal-text text-info me-2"></i>
                        <span>Materi baru tersedia: "CSS Layouting"</span>
                        <small class="text-muted d-block mt-1">3 hari yang lalu</small>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-purple">Pelajari</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    .border-purple-light {
        border-color: rgba(106, 13, 173, 0.2);
    }
    .bg-purple-light {
        background-color: rgba(106, 13, 173, 0.1);
    }
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }
    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1);
    }
    .border-start-lg {
        border-left-width: 4px !important;
    }
</style>
@endsection