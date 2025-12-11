{% include 'layouts/header.php' %}

<section class="section">
    <div class="container fiche-layout">

        <!-- Boîte de gauche : Titre, images, info, statut -->
        <div class="fiche-box fiche-left">
            <h1 class="fiche-title">{{ enchere.timbre_nom }}</h1>

            <div class="fiche-images">

                {% if imagePrincipale is defined and imagePrincipale %}
                    <img 
                        id="fiche-image-principale"
                        src="{{ base }}/img/{{ imagePrincipale }}"
                        alt="Image du timbre {{ enchere.timbre_nom }}"
                        class="fiche-image"
                    />
                {% endif %}

                {# Galerie des miniatures : on commence par l'image principale #}
                <div class="fiche-thumbs">

                    {% if imagePrincipale %}
                        <img 
                            src="{{ base }}/img/{{ imagePrincipale }}"
                            data-full="{{ base }}/img/{{ imagePrincipale }}"
                            alt="Image principale du timbre"
                            class="fiche-thumb"
                        />
                    {% endif %}

                    {% if imagesSecondaires is defined and imagesSecondaires|length > 0 %}
                        {% for img in imagesSecondaires %}
                            <img 
                                src="{{ base }}/img/{{ img }}"
                                data-full="{{ base }}/img/{{ img }}"
                                alt="Image secondaire du timbre {{ enchere.timbre_nom }}"
                                class="fiche-thumb"
                            />
                        {% endfor %}
                    {% endif %}
                </div>

            </div>

            <div class="fiche-infos-section">
                <ul class="fiche-infos">
                    <li><strong>Année :</strong> {{ enchere.annee_publication }}</li>
                    <li><strong>Pays :</strong> {{ enchere.pays_nom }}</li>
                    <li><strong>Condition :</strong> {{ enchere.condition_nom }}</li>
                    <li><strong>Tirage :</strong> {{ enchere.tirage }}</li>
                    <li><strong>Dimensions :</strong> {{ enchere.dimensions }}</li>
                    <li><strong>Certifié :</strong> {{ enchere.certifie ? 'Oui' : 'Non' }}</li>
                </ul>
            </div>

            <div class="fiche-status">
                <p><strong>Ouverture :</strong> {{ enchere.date_ouverture }}</p>
                <p><strong>Fermeture :</strong> {{ enchere.date_fermeture }}</p>
            </div>

        </div>

        <!-- Boîte de droite : mise -->
        <div class="fiche-box fiche-right">

            {% if enchere.est_active %}
                <div class="fiche-badge fiche-badge--active">Active</div>
            {% else %}
                <div class="fiche-badge fiche-badge--closed">Terminée</div>
            {% endif %}

            <h2 class="fiche-form-title">Enchère</h2>

            <p class="fiche-price">
                <strong>Prix plancher :</strong> {{ enchere.prix_plancher }}$
            </p>

            <p class="fiche-status-small">
                Se termine le {{ enchere.date_fermeture }}
            </p>

            <p class="fiche-form-placeholder">
                Formulaire de mise bientôt disponible.
            </p>

        </div>

    </div>
</section>

{% include 'layouts/footer.php' %}
