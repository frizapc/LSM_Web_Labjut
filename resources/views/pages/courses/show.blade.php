@extends('layouts.app')

@section('title', $course->name)

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row">
        <!-- Kolom Foto -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-purple text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-image me-2"></i>Foto Kursus
                    </h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ Storage::url($course->photo) }}" 
                         alt="{{ $course->name }}" 
                         class="img-fluid rounded shadow-lg"
                         style="max-height: 300px; width: auto;">
                </div>
            </div>
        </div>

        <!-- Kolom Detail -->
        <div class="col-lg-8">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-purple text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>Detail Kursus
                        </h5>
                        <span class="badge bg-light text-purple fs-6">
                            {{ $course->code }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Utama -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h2 class="text-purple">{{ $course->name }}</h2>
                                <div class="d-flex align-items-center mt-2">
                                    <span class="badge bg-{{ 
                                        $course->level == 'Pemula' ? 'info' : 
                                        ($course->level == 'Menengah' ? 'warning' : 'danger') 
                                    }} me-2">
                                        {{ $course->level }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        Dibuat {{ $course->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="text-purple mb-3">
                                    <i class="bi bi-people-fill me-2"></i>Peserta Kursus
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="bg-purple-light rounded-circle p-3 me-3">
                                        <i class="bi bi-person-check-fill text-purple" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0">{{ $course->students_count ?? 0 }}</h3>
                                        <small class="text-muted">Siswa terdaftar</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik -->
                        <div class="col-md-6">
                            <div class="card bg-purple-light border-0 h-100">
                                <div class="card-body">
                                    <h5 class="text-purple mb-3">
                                        <i class="bi bi-bar-chart-line me-2"></i>Statistik
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-purple">Kapasitas</span>
                                            <span class="text-purple">50%</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-purple" 
                                                 role="progressbar" 
                                                 style="width: 50%"></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-purple">Penyelesaian</span>
                                            <span class="text-purple">30%</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-purple" 
                                                 role="progressbar" 
                                                 style="width: 30%"></div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <a class="btn btn-purple w-100" href="{{ route('courses.edit', $course->id) }}">
                                            <i class="bi bi-pencil-square me-1"></i> Edit Kursus
                                        </a>
                                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-outline-purple w-100 mt-2"
                                                  onclick="return confirm('Hapus kursus {{ $course->name }}?')">
                                              <i class="bi bi-trash me-1"></i> Hapus
                                          </button>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi Kursus -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header bg-purple text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-journal-text me-2"></i>Deskripsi
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ $course->description ?? 'Belum ada deskripsi tersedia.' }}
                    </p>
                    <a href="#" class="btn btn-sm btn-outline-purple">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Deskripsi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-purple-light {
        background-color: rgba(106, 13, 173, 0.1);
    }
    .text-purple {
        color: #6a0dad;
    }
    .btn-purple {
        background-color: #6a0dad;
        color: white;
    }
    .btn-outline-purple {
        border-color: #6a0dad;
        color: #6a0dad;
    }
    .btn-outline-purple:hover {
        background-color: #6a0dad;
        color: white;
    }
    .progress {
        background-color: rgba(106, 13, 173, 0.2);
    }
</style>
@endsection