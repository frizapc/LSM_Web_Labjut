<div class="sidebar vh-100 fixed-top z-1">
    <div class="mb-4 text-center">
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
            <a class="nav-link" href="#">
                <i class="bi bi-file-earmark-text me-2"></i> Laporan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-gear me-2"></i> Pengaturan
            </a>
        </li>
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const path = window.location.pathname;
    
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.classList.remove('active');
    });
    
    if (path === '/' || path === '/dashboard') {
        console.log(path)
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
    }
});
</script>