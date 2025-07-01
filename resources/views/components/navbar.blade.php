<nav class="navbar navbar-expand-lg navbar-dark bg-purple shadow fixed-top z-2">
    <div class="container-fluid">
        <button id="sidebarToggle" class="navbar-toggler me-2" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand fw-bold" href="#">
            @if(request()->routeIs('courses.exams.show'))
            {{ "$exam->name - $course->name" }}
            @else
            Learning Management System
            @endif
        </a>
        
        <div class="collapse navbar-collapse">
            @auth
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>