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
    @elseif(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row">
        <!-- Kolom Foto -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-purple text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-image me-2"></i>Gambar Kursus
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
                                        <h3 class="mb-0">{{ $course->students_count ?: 0 }}</h3>
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
                                        @can(['update', 'delete'], $course)
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
                                        @endcan
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
                        <i class="bi bi-journal-text me-2"></i>Deskripsi Kursus
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ $course->description ?: 'Belum ada deskripsi tersedia.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Materi Kursus -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-journal-bookmark me-2"></i>Materi
                    </h5>
                    @can('create', App\Models\Course::class)
                    <a href="{{ route('courses.materials.create', $course->id) }}" class="btn btn-sm btn-light-purple">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Materi
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    @if($course->materials->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-journal-x text-purple" style="font-size: 3rem;"></i>
                            <h5 class="text-purple mt-3">{{'Belum ada materi tersedia'}}</h5>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-purple">#</th>
                                        <th class="text-purple">Judul</th>
                                        <th class="text-purple">Deskripsi</th>
                                        <th class="text-purple">Ditambahkan</th>
                                        <th class="text-purple">{{ Auth::user()->role == 'Siswa' ? 'Lihat':'Aksi' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->materials as $index => $material)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $material->name }}</strong>
                                        </td>
                                        <td>
                                        {{ $material->description ?: '-' }}
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $material->created_at->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ Storage::url($material->source) }}" 
                                                target="_blank"
                                                class="btn btn-sm btn-outline-purple"
                                                data-bs-toggle="tooltip" 
                                                title="Baca Materi">
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                </a>
                                                @can(['update', 'delete'], $course)
                                                <a href="{{ route('courses.materials.edit', [$course->id, $material->id]) }}" 
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="tooltip"
                                                title="Edit Ujian">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('courses.materials.destroy', [$course->id, $material->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="tooltip"
                                                            title="Hapus Materi"
                                                            onclick="return confirm('Hapus materi {{ $material->name }}?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
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
    </div>

    <!-- Ujian Kursus -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard2-check me-2"></i>Ujian
                    </h5>
                    @can(['update', 'delete'], $course)
                    <a href="{{ route('courses.exams.create', $course->id) }}" class="btn btn-sm btn-light-purple">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Ujian
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    @if($course->exams->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard2-x text-purple" style="font-size: 3rem;"></i>
                            <h5 class="text-purple mt-3">Belum ada ujian tersedia</h5>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-purple">#</th>
                                        <th class="text-purple">Judul</th>
                                        <th class="text-purple">Catatan</th>
                                        <th class="text-purple">Durasi</th>
                                        <th class="text-purple">Soal</th>
                                        <th class="text-purple">Status</th>
                                        <th class="text-purple">{{ Auth::user()->role == 'Siswa' ? 'Mulai':'Aksi' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->exams as $index => $exam)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $exam->name }}</strong>
                                        </td>
                                        <td>
                                            {{ $exam->note ?: '-' }}
                                        </td>
                                        <td>
                                            {{ $exam->duration }} menit
                                        </td>
                                        <td>
                                            {{ count($exam->questions) }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $exam->is_active ? 'success' : 'secondary' }}">
                                                {{ $exam->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                @cannot(['update', 'delete'], $course)
                                                <button class="btn btn-sm btn-outline-purple"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#startExamModal-{{ $exam->id }}"
                                                data-bs-toggle="tooltip" 
                                                title="Mulai Ujian">
                                                    <i class="bi bi-stopwatch-fill"></i>
                                                </button>
                                                @else
                                                <a href="{{ route('courses.exams.edit', [$course->id, $exam->id]) }}" 
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="tooltip"
                                                title="Edit Ujian">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('courses.exams.destroy', [$course->id, $exam->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="tooltip"
                                                            title="Hapus Ujian"
                                                            onclick="return confirm('Hapus ujian {{ $exam->name }}?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="startExamModal-{{ $exam->id }}" tabindex="-1" aria-labelledby="startExamModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-purple text-white">
                                                            <h5 class="modal-title" id="startExamModalLabel">Konfirmasi Mulai Ujian</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <h6 class="text-purple">{{ $exam->name }}</h6>
                                                                <p class="text-muted small">{{ $exam->note ?: 'Tidak ada deskripsi' }}</p>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <i class="bi bi-list-ol text-purple me-2"></i>
                                                                        <span>Jumlah Soal: {{ count($exam->questions) }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <i class="bi bi-clock text-purple me-2"></i>
                                                                        <span>Durasi: {{ $exam->duration }} menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="text-wrap alert alert-warning mt-3">
                                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                                Pastikan Anda sudah siap sebelum memulai ujian!
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('courses.exams.show', [$course->id, $exam->id]) }}" 
                                                            class="btn btn-{{ $exam->is_active ? 'danger' : 'secondary'}}">
                                                                <i class="bi bi-stopwatch-fill me-1"></i> {{ $exam->is_active ? 'Mulai Sekarang' : 'Nonaktif'}} 
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

@section('scripts')
<script>
    // Inisialisasi tooltip
    $(document).ready(function(){
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endsection