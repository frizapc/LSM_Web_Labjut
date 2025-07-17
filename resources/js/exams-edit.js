document.addEventListener("DOMContentLoaded", function () {
    const isActiveCheckbox = document.getElementById("is_active");
    isActiveCheckbox.addEventListener("change", function () {
        this.value = this.checked ? "1" : "0";
    });

    document.querySelectorAll('.destroy-question-btn').forEach((e, i)=>{
        e.addEventListener('click', () => {
            if(confirm('Ingin menghapus soal ini?')){
                document.querySelectorAll(".deleteQuestionForm")[i].submit();
            }
        })
    });
});