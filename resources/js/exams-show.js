document.addEventListener("DOMContentLoaded", () => {
    const data = window._APP_DATA;

    let answered = localStorage.getItem("quest" + data.currentPage);

    if (answered) {
        const radio = document.getElementById(`option_${answered}`);
        if (radio) {
            radio.checked = true;
            radio.closest(".form-check").classList.add("selected");
        }
    }

    const finishBtn = document.getElementById("finish-btn");
    if (finishBtn) {
        finishBtn.addEventListener("click", () => {
            fetch(data.finishUrl, {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": data.csrfToken,
                },
            })
                .then((response) => {
                    localStorage.clear();
                    clearInterval(timer);
                    if (response.redirected) {
                        window.location.href = response.url;
                    }
                })
                .catch((error) => console.error("Logout error:", error));
        });
    }

    document
        .querySelectorAll('input[type="radio"][name="answer"]')
        .forEach((radio) => {
            radio.addEventListener("change", () => {
                document
                    .querySelectorAll(".form-check")
                    .forEach((el) => el.classList.remove("selected"));

                if (radio.checked) {
                    radio.closest(".form-check").classList.add("selected");
                }

                fetch(data.submitUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": data.csrfToken,
                    },
                    body: JSON.stringify({
                        answer: radio.value,
                    }),
                })
                    .then((response) => response.json())
                    .then((result) => {
                        localStorage.setItem(
                            "quest" + data.currentPage,
                            result.answered
                        );
                        console.log("Jawaban disimpan!", result);
                    })
                    .catch((error) =>
                        console.error("Gagal menyimpan jawaban:", error)
                    );
            });
        });

    // Timer
    let remainingSeconds = Math.floor(parseInt(data.timeLeft));
    const icon = document.querySelector(".bi-clock");
    const textNode = icon ? icon.nextSibling : null;
    const updateTimer = () => {
        if (!textNode) return;

        if (remainingSeconds <= 0) {
            textNode.nodeValue = "00:00";

            fetch(data.finishUrl, {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": data.csrfToken,
                },
            })
                .then((response) => {
                    localStorage.clear();
                    clearInterval(timer);
                    if (response.redirected) {
                        window.location.href = response.url;
                    }
                })
                .catch((error) => console.error("Logout error:", error));

            return;
        }

        const minutes = parseInt(Math.floor(remainingSeconds / 60));
        const seconds = remainingSeconds % 60;
        console.log(minutes);
        textNode.nodeValue = `${minutes.toString().padStart(2, "0")}:${seconds
            .toString()
            .padStart(2, "0")}`;

        remainingSeconds--;
    };

    const timer = setInterval(updateTimer, 1000);
    updateTimer();
});
