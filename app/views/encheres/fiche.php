{% include 'layouts/header.php' %}

<section class="section">
    <div class="container fiche-layout">

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
                <p><strong>Ouverture :</strong> {{ enchere.date_ouverture | date("d/m/Y") }}</p>
                <p><strong>Fermeture :</strong> {{ enchere.date_fermeture | date("d/m/Y") }}</p>
            </div>

        </div>

        <div class="fiche-box fiche-right">

            <div class="fiche-actions-top">

                {% if enchere.est_active %}
                    <div class="fiche-badge fiche-badge--active">Active</div>
                {% else %}
                    <div class="fiche-badge fiche-badge--closed">Terminée</div>
                {% endif %}

                {% if session.user_id %}
                    <form method="POST"
                        action="{{ base }}/encheres/favori"
                        class="form-favori">

                        <input type="hidden" name="enchere_id" value="{{ enchere.idenchere }}">
                        <input type="hidden" name="timbre_id" value="{{ enchere.idtimbre }}">

                        <button type="submit"
                                class="btn-favori {% if est_favori %}is-active{% endif %}"
                                aria-label="Ajouter aux favoris">
                            <i class="{% if est_favori %}fa-solid{% else %}fa-regular{% endif %} fa-heart"></i>
                        </button>
                    </form>
                {% endif %}

            </div>

            <h2 class="fiche-form-title">Enchère</h2>

            <p class="fiche-price">
                <strong>Prix plancher :</strong> {{ enchere.prix_plancher }}$
            </p>

            <p class="fiche-status-small">
                Se termine le {{ enchere.date_fermeture | date("d/m/Y \\à H:i") }}
            </p>

            {% if erreur_offre is defined %}
            <div class="form-errors">
                 <p>{{ erreur_offre }}</p>
             </div>
            {% endif %}

            {% if not session.user_id %}
            <p class="fiche-login-msg">
                <a href="{{ base }}/login">Connectez-vous</a> pour faire une offre.
            </p>

            {% elseif enchere.est_active %}
            <form id="form-offre" action="{{ base }}/encheres/offre" method="POST" class="form-auth" novalidate>
                <input type="hidden" name="enchere_id" value="{{ enchere.idenchere }}">

                <div class="form-group">
                    <label for="montant">Votre offre</label>
                    <input type="number" step="0.01" name="montant" id="montant" placeholder="Minimum {{ prixMin }}$">
                    <div class="message-erreur"></div>
                </div>

                <button type="submit" class="btn-primary">Soumettre l'offre</button>
            </form>

            {% else %}
            <p class="fiche-form-placeholder">Cette enchère est terminée.</p>
            {% endif %}

            <h3 class="section-title">Historique des offres</h3>

            {% if offres is not empty %}
            <ul class="liste-offres">
                {% for o in offres %}
                    <li class="offre-item">
                        <div class="offre-header">
                            <span class="offre-nom">{{ o.prenom }} {{ o.nom }}</span>
                            <span class="offre-montant">{{ o.montant_offert }}$</span>
                        </div>
                        <div class="offre-date">{{ o.date_offre }}</div>
                    </li>
                {% endfor %}
            {% else %}
                <p>Aucune offre pour le moment.</p>
            {% endif %}

        </div>

    </div>
</section>

{% include 'layouts/footer.php' %}
