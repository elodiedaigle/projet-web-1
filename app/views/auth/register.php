{% include 'layouts/header.php' %}

<main class="auth-container">

    <h2>Devenir membre Stampee</h2>

    {% if erreurs is defined and erreurs %}
        <div class="form-errors">
            <ul>
                {% for e in erreurs %}
                    <li>{{ e }}</li>
                {% endfor %}
            </ul>
        </div>
    {% endif %}

    {% if succes is defined %}
        <div class="form-success">
            <p>{{ succes }}</p>
        </div>
    {% endif %}

    <form action="{{ base }}/register" method="POST" class="form-auth">

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="courriel">Courriel</label>
        <input type="email" id="courriel" name="courriel" required>

        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <label for="mot_de_passe_confirmation">Confirmation du mot de passe</label>
        <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" required>

        <button type="submit" class="btn-primary">Créer mon compte</button>

        <p class="auth-link">
            Déjà inscrit ? <a href="{{ base }}/login">Se connecter</a>
        </p>

    </form>
</main>

{% include 'layouts/footer.php' %}
