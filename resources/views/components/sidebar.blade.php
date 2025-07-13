<div class="sidebar mt-lg-5 vh-100 fixed-top z-1">
    @auth
    @if(request()->routeIs('courses.exams.show'))
    <div class="my-2 text-center">
        <h5 class="text-white">Soal</h5>
    </div>

    <div class="question-numbers">
        @php
        $currentPage = request()->query('page', 1);
        $totalQuestions = count($exam->questions);
        $rows = ceil($totalQuestions / 5);
        @endphp
        
        @for($i = 0; $i < $rows; $i++)
            <div class="d-flex justify-content-center">
                @for($j = 1; $j <= 5; $j++)
                    @php
                        $questionNumber = $i * 5 + $j;
                        if($questionNumber > $totalQuestions) break;
                    @endphp
                    <a href="{{ route('courses.exams.show', [$course->id, $exam->id, 'page' => $questionNumber]) }}"
                        class="nav-link border border-white fw-bold question-number">
                        {{ $questionNumber }}
                    </a>
                @endfor
            </div>
        @endfor
    </div>
    @else
    <div class="my-2 text-center">
        <h5 class="text-white">Menu</h5>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="/">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-people me-2"></i> Pengguna
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/courses">
                <i class="bi bi-box-seam me-2"></i> Kursus
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/reports">
                <i class="bi bi-file-earmark-text me-2"></i> Laporan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-gear me-2"></i> Pengaturan
            </a>
        </li>
        <div class="account-set w-100 position-absolute bottom-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <i class="bi bi-person-circle me-2"></i> Profil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </div>
    </ul>
    @endif
    @endauth

    @guest
    <div class="my-2 text-center">
        <h5 class="text-white">Menu</h5>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">
                <i class="bi bi-person-plus me-2"></i> Register
            </a>
        </li>
    </ul>
    @endguest
</div>

@push('styles')
<link href="{{ asset('css/sidebar.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/sidebar.min.js') }}"></script>
@endpush



