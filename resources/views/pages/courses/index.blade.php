@extends('layouts.app')

@section('title', 'Daftar Kursus')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-header bg-purple text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-book me-2"></i>Daftar Kursus
                </h5>
                @can('create', App\Models\Course::class)
                <a href="{{ route('courses.create') }}" class="btn btn-light-purple">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Baru
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            @if($courses->isEmpty())
                <div class="alert alert-purple text-center">
                    <i class="bi bi-info-circle me-2"></i>Belum ada kursus tersedia.
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($courses as $course)
                    <div class="col">
                        <div class="card h-100 course-card hover-scale">
                            <div class="position-relative">
                                <img src="{{ Storage::url($course->photo) }}" class="card-img-top" alt="{{ $course->name }}">
                                <span class="badge bg-{{ $course->level == 'Pemula' ? 'info' : ($course->level == 'Menengah' ? 'warning' : 'danger') }} position-absolute top-0 end-0 m-2">
                                    {{ $course->level }}
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title title-purple">
                                    {{ $course->name }}
                                </h5>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-purple-light text-purple">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ $course->created_at->diffForHumans() }}
                                    </span>
                                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-outline-purple">
                                        Detail <i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                </div>
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
<link rel="stylesheet" href="{{ asset('css/courses-index.min.css') }}">
@endpush