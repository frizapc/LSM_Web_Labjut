document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");
    const toggleIcon = document.querySelector("#toggleIcon");

    togglePassword.addEventListener("click", function () {
        // Toggle the type attribute
        const type =
            password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // Toggle the icon
        toggleIcon.classList.toggle("bi-eye");
        toggleIcon.classList.toggle("bi-eye-slash");
    });
});
