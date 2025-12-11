document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#form-creer-enchere');
    if (!form) return;

    const nom = form.querySelector('#nom');
    const annee = form.querySelector('#annee_publication');
    const tirage = form.querySelector('#tirage');
    const dimensions = form.querySelector('#dimensions');
    const couleurs = form.querySelector('#couleurs');
    const pays = form.querySelector('#pays');
    const condition = form.querySelector('#condition');
    const prix = form.querySelector('#prix_plancher');
    const ouverture = form.querySelector('#date_ouverture');
    const fermeture = form.querySelector('#date_fermeture');
    const image = form.querySelector('#image_principale');

    const showError = (input, message) => {
        const container = input.closest('.form-group');
        const msg = container.querySelector('.message-erreur');
        msg.textContent = message;
        container.classList.add('erreur');
    };

    const clearError = (input) => {
        const container = input.closest('.form-group');
        const msg = container.querySelector('.message-erreur');
        msg.textContent = '';
        container.classList.remove('erreur');
    };

    form.addEventListener('submit', (e) => {
        let valid = true;

        // Nom
        if (nom.value.trim() === '') {
            valid = false;
            showError(nom, 'Le nom du timbre est requis.');
        } else clearError(nom);

        // Année
        if (annee.value.trim() === '') {
            valid = false;
            showError(annee, 'L\'année de publication est requise.');
        } else clearError(annee);

        // Tirage
        if (tirage.value.trim() === '') {
            valid = false;
            showError(tirage, 'Le tirage est requis.');
        } else clearError(tirage);

        // Dimensions
        if (dimensions.value.trim() === '') {
            valid = false;
            showError(dimensions, 'Les dimensions sont requises.');
        } else clearError(dimensions);

        // Couleurs
        if (couleurs.selectedOptions.length === 0) {
            valid = false;
            showError(couleurs, 'Au moins une couleur est requise.');
        } else clearError(couleurs);

        // Pays
        if (pays.value.trim() === '') {
            valid = false;
            showError(pays, 'Le pays est requis.');
        } else clearError(pays);

        // Condition
        if (condition.value.trim() === '') {
            valid = false;
            showError(condition, 'La condition est requise.');
        } else clearError(condition);

        // Prix plancher
        if (prix.value.trim() === '') {
            valid = false;
            showError(prix, 'Le prix plancher est requis.');
        } else clearError(prix);

        // Date ouverture
        if (ouverture.value.trim() === '') {
            valid = false;
            showError(ouverture, 'La date d\'ouverture est requise.');
        } else clearError(ouverture);

        // Date fermeture
        if (fermeture.value.trim() === '') {
            valid = false;
            showError(fermeture, 'La date de fermeture est requise.');
        } else clearError(fermeture);

        // Image principale
        if (image.files.length === 0) {
            valid = false;
            showError(image, 'L\'image principale est obligatoire.');
        } else clearError(image);

        if (!valid) {
            e.preventDefault();
        }
    });
});
