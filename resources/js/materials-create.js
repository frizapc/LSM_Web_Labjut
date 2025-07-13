document.getElementById("source").addEventListener("change", function (e) {
    const preview = document.getElementById("pdf-preview");
    const file = e.target.files[0];

    if (file && file.type === "application/pdf") {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove("d-none");
        };

        reader.readAsDataURL(file);
    } else {
        preview.classList.add("d-none");
        if (file) alert("Hanya file PDF yang diperbolehkan");
    }
});
