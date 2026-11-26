document.addEventListener("DOMContentLoaded"), function () {

    // =========================
    // BUKA UNDANGAN
    // =========================
    const openButton = document.getElementById("openButton");
    const cover = document.getElementById("cover");
    const content = document.getElementById("content");
    const music = document.getElementById("music");
    const musicButton = document.getElementById("musicButton");
    const musicStatus = document.getElementById("musicStatus");

    if (openButton) {
        openButton.addEventListener("click", function () {
            if (cover) cover.style.display = "none";
            if (content) content.style.display = "block";

            if (music) {
                music.play().then(() => {
                    if (musicStatus) musicStatus.textContent = "Musik menyala ♫";
                }).catch(() => {
                    if (musicStatus) musicStatus.textContent = "Klik tombol musik untuk memutar";
                });
            }
        });
    }
}
    // =========================
    // TOMBOL MUSIK
    // =========================
    if (musicButton && music) {
        musicButton.addEventListener("click", function () {
            if (music.paused) {
                music.play().then(() => {
                    if (musicStatus) musicStatus.textContent = "Musik menyala ♫";
                }).catch(() => {
                    if (musicStatus) musicStatus.textContent = "Musik gagal diputar";
                });
            } else {
                music.pause();
                if (musicStatus) musicStatus.textContent = "Musik dimatikan";
            }
        });
    }

    // =========================
    // COUNTDOWN
    // =========================
    const targetDate = new Date("March 10, 2027 15:00:00").getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        const days = document.getElementById("days");
        const hours = document.getElementById("hours");
        const minutes = document.getElementById("minutes");
        const seconds = document.getElementById("seconds");

        if (distance <= 0) {
            if (days) days.textContent = "0";
            if (hours) hours.textContent = "0";
            if (minutes) minutes.textContent = "0";
            if (seconds) seconds.textContent = "0";
            return;
        }

        if (days) days.textContent = Math.floor(distance / (1000 * 60 * 60 * 24));
        if (hours) hours.textContent = Math.floor((distance / (1000 * 60 * 60)) % 24);
        if (minutes) minutes.textContent = Math.floor((distance / (1000 * 60)) % 60);
        if (seconds) seconds.textContent = Math.floor((distance / 1000) % 60);
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);

    // =========================
    // POPUP FOTO GALERI
    // =========================
    const photoModal = document.getElementById("photoModal");
    const modalImage = document.getElementById("modalImage");
    const closeModal = document.getElementById("closeModal");

    document.querySelectorAll(".gallery img").forEach(function (img) {
        img.addEventListener("click", function () {
            if (photoModal && modalImage) {
                modalImage.src = img.src;
                modalImage.alt = img.alt;
                photoModal.style.display = "flex";
            }
        });
    });

    if (closeModal && photoModal) {
        closeModal.addEventListener("click", function () {
            photoModal.style.display = "none";
        });
    }

    if (photoModal) {
        photoModal.addEventListener("click", function (event) {
            if (event.target === photoModal) {
                photoModal.style.display = "none";
            }
        });
    }

    // =========================
    // COPY NOMOR REKENING
    // =========================
    const copyButton = document.getElementById("copyButton");

    if (copyButton) {
        copyButton.addEventListener("click", async function () {
            const rekening = "1234567890";

            try {
                await navigator.clipboard.writeText(rekening);
                copyButton.textContent = "Berhasil disalin!";
                setTimeout(() => {
                    copyButton.textContent = "Salin Nomor Rekening";
                }, 2000);
            } catch (error) {
                alert("Nomor rekening: " + rekening);
            }
        });
    }
// =========================
// FORM RSVP / UCAPAN
// =========================

const GOOGLE_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbwm1VYj-pavAwStA20VCCBCGCGW_QUzNNOwVrDdrcQigvlaWMcR9RS1lI07IUM6e8L9/exec";

const rsvpForm = document.getElementById("rsvpForm");
const responseMessage = document.getElementById("responseMessage");
const submitButton = document.getElementById("submitButton");

if (rsvpForm) {
    rsvpForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        submitButton.disabled = true;
        submitButton.textContent = "Mengirim...";

        responseMessage.textContent = "";

        const data = new URLSearchParams();

        data.append("name", rsvpForm.querySelector('[name="name"]').value);
        data.append("whatsapp", rsvpForm.querySelector('[name="whatsapp"]').value);
        data.append("attendance", rsvpForm.querySelector('[name="attendance"]').value);
        data.append("wish", rsvpForm.querySelector('[name="wish"]').value);

        try {
            await fetch(GOOGLE_SCRIPT_URL, {
                method: "POST",
                mode: "no-cors",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: data.toString()
            });

            responseMessage.textContent = "Pesan berhasil dikirim ♡";
            responseMessage.style.color = "green";

            rsvpForm.reset();

        } catch (error) {
            responseMessage.textContent = "Gagal mengirim pesan. Coba lagi.";
            responseMessage.style.color = "red";

        } finally {
            submitButton.disabled = false;
            submitButton.textContent = "Kirim";
        }
    });
}