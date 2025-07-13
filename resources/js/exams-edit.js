document.addEventListener("DOMContentLoaded", function () {
    const isActiveCheckbox = document.getElementById("is_active");
    isActiveCheckbox.addEventListener("change", function () {
        this.value = this.checked ? "1" : "0";
    });
});

function confirmDelete(ids) {
    if (confirm("Apakah Anda yakin ingin menghapus soal ini?")) {
        const form = document.getElementById("deleteQuestionForm");
        form.action = `/courses/${ids[0]}/exams/${ids[1]}/questions/${ids[2]}`;
        form.submit();
    }
}
