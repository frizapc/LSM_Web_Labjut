document.getElementById("photo").addEventListener("change", function (e) {
    const preview = document.getElementById("image-preview");
    const file = e.target.files[0];

    if (file) {
        const previewLabel = document.createElement("p");
        previewLabel.className = "small text-muted mt-2";
        previewLabel.textContent = "Preview Foto Baru:";
        preview.parentNode.insertBefore(previewLabel, preview);

        if (file.size > 2 * 1024 * 1024) {
            alert("Ukuran file maksimal 2MB");
            this.value = "";
            return;
        }

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
