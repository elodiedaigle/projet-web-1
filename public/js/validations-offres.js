// Attendre que la page soit chargée
document.addEventListener('DOMContentLoaded', () => {

    // Sélectionner le formulaire
    const form = document.querySelector('#form-offre');
    if (!form) return;

    // Sélectionner le champ montant
    const montant = form.querySelector('#montant');

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

    // Validations
    form.addEventListener('submit', (e) => {
        let valid = true;

        // Montant vide
        if (montant.value.trim() === '') {
            valid = false;
            showError(montant, 'Veuillez entrer un montant.');
        }

        // Montant invalide
        else if (isNaN(parseFloat(montant.value)) || parseFloat(montant.value) <= 0) {
            valid = false;
            showError(montant, 'Le montant doit être un nombre valide.');
        } 
        else {
            clearError(montant);
        }

        if (!valid) {
            e.preventDefault();
        }
    });
});
