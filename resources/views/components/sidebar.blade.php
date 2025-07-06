<div class="sidebar mt-5 vh-100 fixed-top z-1">
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const path = window.location.pathname;
    
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.classList.remove('active');
    });
    
    if (path === '/' || path === '/dashboard') {
        const dashboardLink = Array.from(navLinks).find(link => 
            link.textContent.includes('Dashboard') || 
            link.querySelector('.bi-speedometer2')
        );
        if (dashboardLink) dashboardLink.classList.add('active');
    } else if (path.startsWith('/courses')) {

        const kursusLink = Array.from(navLinks).find(link => 
            link.textContent.includes('Kursus') || 
            link.querySelector('.bi-box-seam')
        );
        if (kursusLink) kursusLink.classList.add('active');
    } else if (path.startsWith('/users')) {

        const penggunaLink = Array.from(navLinks).find(link => 
            link.textContent.includes('Pengguna') || 
            link.querySelector('.bi-people')
        );
        if (penggunaLink) penggunaLink.classList.add('active');
    } else if (path.startsWith('/reports')) {

        const laporanLink = Array.from(navLinks).find(link => 
            link.textContent.includes('Laporan') || 
            link.querySelector('.bi-file-earmark-text')
        );
        if (laporanLink) laporanLink.classList.add('active');
    } else if (path.startsWith('/settings')) {

        const pengaturanLink = Array.from(navLinks).find(link => 
            link.textContent.includes('Pengaturan') || 
            link.querySelector('.bi-gear')
        );
        if (pengaturanLink) pengaturanLink.classList.add('active');
    } else if (path.startsWith('/login')) {

        const pengaturanLink = Array.from(navLinks).find(link => 
            link.textContent.includes('Login') || 
            link.querySelector('.bi-box-arrow-in-right')
        );
        if (pengaturanLink) pengaturanLink.classList.add('active');
    } else if (path.startsWith('/register')) {

        const pengaturanLink = Array.from(navLinks).find(link => 
            link.textContent.includes('Register') || 
            link.querySelector('.bi-person-plus')
        );
        if (pengaturanLink) pengaturanLink.classList.add('active');
    }

    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = urlParams.get('page') || 1;
    console.log(currentPage);
    const questionLinks = document.querySelectorAll('.question-number');
    questionLinks.forEach((link, key) => {
        const answered = localStorage.getItem(`quest${key+1}`);
        const questionNumber = parseInt(link.innerText);
        
        // Bandingkan dengan currentPage
        if (questionNumber == currentPage || answered) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});
</script>