{% include 'layouts/header.php' %}

<main class="auth-container">

    <h2>Connexion</h2>

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

    <form id="form-login" action="{{ base }}/login" method="POST" class="form-auth" novalidate>

        <div class="form-group">
            <label for="courriel">Courriel</label>
            <input type="email" id="courriel" name="courriel" 
                   value="{{ old.courriel ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            <div class="message-erreur"></div>
        </div>

        <button type="submit" class="btn-primary">Se connecter</button>

        <p class="auth-link">
            Pas encore membre? <a href="{{ base }}/register">Créer un compte</a>
        </p>

    </form>
</main>

{% include 'layouts/footer.php' %}
