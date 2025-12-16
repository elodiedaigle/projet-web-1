// Attendre que la page soit chargée
document.addEventListener("DOMContentLoaded", () => {

    // Sélectionner l'image principale affichée dans la fiche
    const imageZoom = document.getElementById("imageZoom");
    if (!imageZoom) return;

    // Sélectionner les images
    const mainImg = imageZoom.querySelector("img");
    const thumbs = document.querySelectorAll(".fiche-thumb");

    // Remplacer l'image vue en gros quand on clique sur une miniature
    thumbs.forEach(thumb => {
        thumb.addEventListener("click", () => {
            const newSrc = thumb.dataset.full;

            // Changer l'image invisible
            mainImg.src = newSrc;

            // Changer l'image utilisée pour le zoom
            imageZoom.style.setProperty(
                "--url", `url('${newSrc}')`
            );
        });
    });
});
