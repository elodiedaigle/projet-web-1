// Attendre que la page soit chargée
document.addEventListener('DOMContentLoaded', () => {

    // Sélectionner le formulaire
    const form = document.querySelector('#form-login');
    if (!form) return;

    // Sélectionner les champs du formulaire
    const courriel = form.querySelector('input[name="courriel"]');
    const mdp = form.querySelector('input[name="mot_de_passe"]');

    // Afficher un message d'erreur
    const showError = (input, message) => {
        const container = input.closest('.form-group');
        const msg = container.querySelector('.message-erreur');
        msg.textContent = message;
        container.classList.add('erreur');
    };

    // Effacer un message d'erreur
    const clearError = (input) => {
        const container = input.closest('.form-group');
        const msg = container.querySelector('.message-erreur');
        msg.textContent = '';
        container.classList.remove('erreur');
    };

    // Vérifier le format du courriel
    const isEmailValid = (email) => {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    };
    
    // Validations
    form.addEventListener('submit', (e) => {
        let valid = true;

        // Courriel
        if (courriel.value.trim() === '') {
            valid = false;
            showError(courriel, 'Le courriel est requis.');
        } else if (!isEmailValid(courriel.value)) {
            valid = false;
            showError(courriel, 'Le format du courriel invalide.');
        } else clearError(courriel);

        // Mot de passe
        if (mdp.value.trim() === '') {
            valid = false;
            showError(mdp, 'Le mot de passe est requis.');
        } else clearError(mdp);

        if (!valid) {
            e.preventDefault();
        }
    });
});
