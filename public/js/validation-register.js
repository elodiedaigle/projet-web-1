document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#form-register');
    if (!form) return;

    const prenom = form.querySelector('input[name="prenom"]');
    const nom = form.querySelector('input[name="nom"]');
    const courriel = form.querySelector('input[name="courriel"]');
    const mdp = form.querySelector('input[name="mot_de_passe"]');
    const mdpConf = form.querySelector('input[name="mot_de_passe_confirmation"]');

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

    const isEmailValid = (email) => {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    };

    form.addEventListener('submit', (e) => {
        let valid = true;

        // Prénom
        if (prenom.value.trim() === '') {
            valid = false;
            showError(prenom, 'Le prénom est requis.');
        } else clearError(prenom);

        // Nom
        if (nom.value.trim() === '') {
            valid = false;
            showError(nom, 'Le nom est requis.');
        } else clearError(nom);

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

        // Confirmation
        if (mdpConf.value.trim() === '') {
            valid = false;
            showError(mdpConf, 'La confirmation du mot de passe est requise.');
        } else if (mdpConf.value !== mdp.value) {
            valid = false;
            showError(mdpConf, 'Les mots de passe ne correspondent pas.');
        } else clearError(mdpConf);

        if (!valid) {
            e.preventDefault();
        }
    });
});
