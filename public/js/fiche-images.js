document.addEventListener("DOMContentLoaded", () => {
    const mainImg = document.getElementById("fiche-image-principale");
    const thumbs = document.querySelectorAll(".fiche-thumb");

    thumbs.forEach(thumb => {
        thumb.addEventListener("click", () => {
            mainImg.src = thumb.dataset.full;
        });
    });
});
