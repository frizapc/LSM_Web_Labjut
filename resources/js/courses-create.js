document.getElementById("photo").addEventListener("change", function (e) {
    const preview = document.getElementById("image-preview");
    const file = e.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove("d-none");
        };

        reader.readAsDataURL(file);
    } else {
        preview.classList.add("d-none");
    }
});
