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

<style>
    .question-numbers {
        padding: 0.5rem;
    }
    
    .question-number {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0.25rem;
        background-color: rgba(255, 255, 255, 0.1);
        transition: all 0.2s;
    }
    
    .question-number:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .question-number.active {
        background-color: #6a0dad;
        color: white;
        font-weight: bold;
    }

    .account-set{
        margin-bottom: 4.2rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const path = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Reset semua active class
    navLinks.forEach(link => link.classList.remove('active'));
    
    // Fungsi untuk mencocokkan link
    function findActiveLink(selector, textMatch, iconClass) {
        const links = document.querySelectorAll(selector);
        links.forEach(link => {
            const linkText = link.textContent.trim().toLowerCase();
            const hasIcon = link.querySelector(iconClass);
            
            if (linkText.includes(textMatch.toLowerCase()) || hasIcon) {
                link.classList.add('active');
            }
        });
    }

    // Cek path dan set active class
    if (path === '/' || path === '/dashboard') {
        findActiveLink('.nav-link', 'Dashboard', '.bi-speedometer2');
    } 
    else if (path.startsWith('/courses')) {
        findActiveLink('.nav-link', 'Kursus', '.bi-box-seam');
    }
    else if (path.startsWith('/users')) {
        findActiveLink('.nav-link', 'Pengguna', '.bi-people');
    }
    else if (path.startsWith('/reports')) {
        findActiveLink('.nav-link', 'Laporan', '.bi-file-earmark-text');
    }
    else if (path.startsWith('/settings')) {
        findActiveLink('.nav-link', 'Pengaturan', '.bi-gear');
    }
    else if (path.startsWith('/login')) {
        findActiveLink('.nav-link', 'Login', '.bi-box-arrow-in-right');
    }
    else if (path.startsWith('/register')) {
        findActiveLink('.nav-link', 'Register', '.bi-person-plus');
    }
    else if (path.startsWith('/profile')) {
        console.log('Profile path detected');
        findActiveLink('.nav-link', 'Profil', '.bi-person-circle');
    }

    // Logic untuk question numbers
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = urlParams.get('page') || 1;
    const questionLinks = document.querySelectorAll('.question-number');
    
    questionLinks.forEach((link) => {
        const answered = localStorage.getItem(`quest${link.textContent}`);
        const questionNumber = parseInt(link.textContent);
        
        if (questionNumber == currentPage || answered) {
            link.classList.add('active');
        }
    });
});
</script>