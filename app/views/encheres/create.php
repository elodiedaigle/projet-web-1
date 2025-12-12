{% include 'layouts/header.php' %}

<main class="auth-container">

    <h2>Créer une enchère</h2>

    {% if erreurs is defined and erreurs %}
        <div class="form-errors">
            <ul>
                {% for e in erreurs %}
                    <li>{{ e }}</li>
                {% endfor %}
            </ul>
        </div>
    {% endif %}

    <form id="form-creer-enchere" action="{{ base }}/encheres/create" 
          method="POST" enctype="multipart/form-data" class="form-auth" novalidate>

        <h3 class="section-title">Informations du timbre</h3>

        <div class="form-group">
            <label for="nom">Nom du timbre</label>
            <input type="text" id="nom" name="nom" value="{{ old.nom ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="annee_publication">Année de publication</label>
            <input type="number" id="annee_publication" name="annee_publication" value="{{ old.annee_publication ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="tirage">Tirage</label>
            <input type="number" id="tirage" name="tirage" value="{{ old.tirage ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="dimensions">Dimensions</label>
            <input type="text" id="dimensions" name="dimensions" value="{{ old.dimensions ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label>Couleurs</label>
            <div class="checkbox-group">
                {% for c in couleurs %}
                    <label class="checkbox-item">
                        <input type="checkbox" name="couleurs[]" value="{{ c.idCouleur }}"
                        {% if old.couleurs is defined and c.idCouleur in old.couleurs %}checked{% endif %}>
                        {{ c.nom }}
                    </label>
                {% endfor %}
            </div>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="pays">Pays</label>
            <input type="text" id="pays" name="pays" value="{{ old.pays ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="condition">Condition</label>
            <select id="condition" name="condition" required>
                {% for cond in conditions %}
                    <option value="{{ cond.idTimbreCondition }}"
                        {% if old.condition is defined and old.condition == cond.idTimbreCondition %}selected{% endif %}>
                        {{ cond.nom }}
                    </option>
                {% endfor %}
            </select>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="certifie">Certifié</label>

            <label class="checkbox-item checkbox--single">
                <input type="checkbox" id="certifie" name="certifie" value="1" {% if old.certifie is defined %}checked{% endif %}>
                Oui
            </label>
        </div>

        <div class="form-group">
            <label for="image_principale">Image principale</label>
            <input type="file" id="image_principale" name="image_principale" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="images_secondaires">Images secondaires (non obligatoire)</label>
            <input type="file" id="images_secondaires" name="images_secondaires[]" multiple>
            <div class="message-erreur"></div>
        </div>

        <h3 class="section-title">Informations de l'enchère</h3>

        <div class="form-group">
            <label for="prix_plancher">Prix plancher</label>
            <input type="number" id="prix_plancher" name="prix_plancher" 
                   value="{{ old.prix_plancher ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="date_ouverture">Date d'ouverture</label>
            <input type="datetime-local" id="date_ouverture" name="date_ouverture" value="{{ old.date_ouverture ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <div class="form-group">
            <label for="date_fermeture">Date de fermeture</label>
            <input type="datetime-local" id="date_fermeture" name="date_fermeture" value="{{ old.date_fermeture ?? '' }}" required>
            <div class="message-erreur"></div>
        </div>

        <button type="submit" class="btn-primary">Créer l'enchère</button>

    </form>

</main>

{% include 'layouts/footer.php' %}
