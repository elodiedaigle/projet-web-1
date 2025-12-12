// Attendre que la page soit chargée
document.addEventListener("DOMContentLoaded", () => {

    // Sélectionner l'image principale affichée dans la fiche
    const mainImg = document.getElementById("fiche-image-principale");

    // Sélectionner les miniatures
    const thumbs = document.querySelectorAll(".fiche-thumb");

    // Remplacer l'image vue en gros quand on clique sur une miniature
    thumbs.forEach(thumb => {
        thumb.addEventListener("click", () => {
            mainImg.src = thumb.dataset.full;
        });
    });
});
