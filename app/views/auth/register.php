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

    <form id="form-register" action="{{ base }}/register" method="POST" class="form-auth">

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" value="{{ old.prenom ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ old.nom ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="courriel">Courriel</label>
            <input type="email" id="courriel" name="courriel" value="{{ old.courriel ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="mot_de_passe_confirmation">Confirmation du mot de passe</label>
            <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" required>
            <div class="message-erreur"></div>
        </div>

        <button type="submit" class="btn-primary">Créer mon compte</button>

        <p class="auth-link">
            Déjà inscrit? <a href="{{ base }}/login">Se connecter</a>
        </p>

    </form>
</main>

{% include 'layouts/footer.php' %}
