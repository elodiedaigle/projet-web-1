// Attendre que la page soit chargée
document.addEventListener('DOMContentLoaded', () => {

    // Sélectionner le bouton burger
    const burger = document.querySelector('.burger');

    // Sélectionner la navigation mobile
    const nav = document.querySelector('.nav-mobile');

    // Si un des deux éléments n'existe pas, on fait rien
    if (!burger || !nav) return;

    // Si oui, à chaque clic, le menu mobile s'ouvre ou se ferme
    burger.addEventListener('click', () => {
        nav.classList.toggle('open');
    });
});
