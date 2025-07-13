document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const path = window.location.pathname;
    const navLinks = document.querySelectorAll(".nav-link");

    // Reset semua active class
    navLinks.forEach((link) => link.classList.remove("active"));

    // Fungsi untuk mencocokkan link
    function findActiveLink(selector, textMatch, iconClass) {
        const links = document.querySelectorAll(selector);
        links.forEach((link) => {
            const linkText = link.textContent.trim().toLowerCase();
            const hasIcon = link.querySelector(iconClass);

            if (linkText.includes(textMatch.toLowerCase()) || hasIcon) {
                link.classList.add("active");
            }
        });
    }

    // Cek path dan set active class
    if (path === "/" || path === "/dashboard") {
        findActiveLink(".nav-link", "Dashboard", ".bi-speedometer2");
    } else if (path.startsWith("/courses")) {
        findActiveLink(".nav-link", "Kursus", ".bi-box-seam");
    } else if (path.startsWith("/users")) {
        findActiveLink(".nav-link", "Pengguna", ".bi-people");
    } else if (path.startsWith("/reports")) {
        findActiveLink(".nav-link", "Laporan", ".bi-file-earmark-text");
    } else if (path.startsWith("/settings")) {
        findActiveLink(".nav-link", "Pengaturan", ".bi-gear");
    } else if (path.startsWith("/login")) {
        findActiveLink(".nav-link", "Login", ".bi-box-arrow-in-right");
    } else if (path.startsWith("/register")) {
        findActiveLink(".nav-link", "Register", ".bi-person-plus");
    } else if (path.startsWith("/profile")) {
        console.log("Profile path detected");
        findActiveLink(".nav-link", "Profil", ".bi-person-circle");
    }

    // Logic untuk question numbers
    const currentPage = urlParams.get("page") || 1;
    const questionLinks = document.querySelectorAll(".question-number");

    questionLinks.forEach((link) => {
        const questionNumber = parseInt(link.textContent);
        const answered = localStorage.getItem(`quest${questionNumber}`);

        if (questionNumber == currentPage || answered) {
            link.classList.add("active");
        }
    });
});
