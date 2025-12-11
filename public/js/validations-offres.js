document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#form-offre');
    if (!form) return;

    const montant = form.querySelector('#montant');

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

        // Montant vide
        if (montant.value.trim() === '') {
            valid = false;
            showError(montant, 'Veuillez entrer un montant.');
        } 
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
