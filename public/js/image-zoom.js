// Attendre que la page soit chargée
document.addEventListener('DOMContentLoaded', () => {

  // Sélectionner le conteneur de l'image avec effet zoom
  const imageZoom = document.getElementById('imageZoom');

  // Si l’élément n’existe pas sur la page, stop
  if (!imageZoom) return;

  // Gérer le déplacement de la souris
  imageZoom.addEventListener('mousemove', (e) => {

    // Calculer la position du curseur en pourcentage par rapport à la taille de l’image
    const x = (e.offsetX * 100) / imageZoom.offsetWidth;
    const y = (e.offsetY * 100) / imageZoom.offsetHeight;

    // Mettre à jour les variables CSS utilisées pour déplacer la zone de zoom
    imageZoom.style.setProperty('--zoom-x', `${x}%`);
    imageZoom.style.setProperty('--zoom-y', `${y}%`);

    // Afficher l’effet de zoom quand la souris hover sur l’image
    imageZoom.style.setProperty('--display', 'block');
  });

  // Cacher l’effet de zoom quand la souris est en dehors l’image
  imageZoom.addEventListener('mouseleave', () => {
    imageZoom.style.setProperty('--display', 'none');
  });
});
