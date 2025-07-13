document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("sidebarToggle")
        .addEventListener("click", function () {
            document.querySelector(".sidebar").classList.toggle("active");
        });
});
