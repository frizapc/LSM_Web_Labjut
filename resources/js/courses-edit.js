document.getElementById("photo").addEventListener("change", function (e) {
    const preview = document.getElementById("image-preview");
    const file = e.target.files[0];

    if (file) {
        // Cek apakah label preview sudah ada
        let previewLabel = preview.previousElementSibling;

        // Buat label jika belum ada
        if (
            !previewLabel ||
            !previewLabel.classList.contains("preview-label")
        ) {
            previewLabel = document.createElement("p");
            previewLabel.className = "small text-muted preview-label";
            previewLabel.textContent = "Preview Foto Baru:";
            preview.parentNode.insertBefore(previewLabel, preview);
        }

        // Tampilkan label
        previewLabel.classList.remove("d-none");

        // Proses preview gambar
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
    } else {
        // Sembunyikan label dan preview jika tidak ada file
        const previewLabel = preview.previousElementSibling;
        if (previewLabel && previewLabel.classList.contains("preview-label")) {
            previewLabel.classList.add("d-none");
        }
        preview.classList.add("d-none");
    }
});
