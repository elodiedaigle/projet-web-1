{% include 'layouts/header.php' %}

<section class="section">
    <div class="container enchere-layout">

        <aside class="enchere-filters">

            <h3 class="filters-title">Filtrer</h3>
            <hr class="filters-separator">

            <form method="GET">

                <div class="filter-group">
                    <p class="filter-group-title">Pays</p>
                    <input type="text" name="pays" value="{{ pays }}">
                </div>

                <div class="filter-group">
                    <p class="filter-group-title">Année de publication</p>
                    <input type="number" name="annee" min="0" value="{{ annee }}">
                </div>

                <div class="filter-group">
                    <p class="filter-group-title">Condition</p>
                    <ul class="radio-list">
                        {% for c in conditions %}
                        <li class="radio-item">
                            <input type="radio" id="cond{{ c.idTimbreCondition }}" name="condition" value="{{ c.idTimbreCondition }}" {% if condition == c.idTimbreCondition %}checked{% endif %}>
                            <label for="cond{{ c.idTimbreCondition }}">{{ c.nom }}</label>
                        </li>
                        {% endfor %}
                        <li class="radio-item">
                            <input type="radio" id="condAll" name="condition" value="all" {% if condition is same as(null) or condition == 'all' %}checked{% endif %}>
                            <label for="condAll">Tous</label>
                        </li>
                    </ul>
                </div>

                <div class="filter-group">
                    <p class="filter-group-title">Certifié</p>
                    <ul class="radio-list">
                        <li class="radio-item">
                            <input type="radio" id="certOui" name="certifie" value="1" {% if certifie == '1' %}checked{% endif %}>
                            <label for="certOui">Oui</label>
                        </li>
                        <li class="radio-item">
                            <input type="radio" id="certNon" name="certifie" value="0" {% if certifie == '0' %}checked{% endif %}>
                            <label for="certNon">Non</label>
                        </li>
                        <li class="radio-item">
                            <input type="radio" id="certTous" name="certifie" value="" {% if certifie is same as(null) or certifie == '' %}checked{% endif %}>
                            <label for="certTous">Tous</label>
                        </li>
                    </ul>
                </div>

                <div class="filter-group">
                    <p class="filter-group-title">Couleur</p>
                    <ul class="radio-list">
                        {% for col in couleurs %}
                            <li class="radio-item">
                                <input
                                    type="radio"
                                    id="couleur{{ col.idCouleur }}"
                                    name="couleur"
                                    value="{{ col.idCouleur }}"
                                    {% if couleur == col.idCouleur %}checked{% endif %}
                                >
                                <label for="couleur{{ col.idCouleur }}">{{ col.nom }}</label>
                            </li>
                        {% endfor %}

                        <li class="radio-item">
                            <input
                                type="radio"
                                id="couleurAll"
                                name="couleur"
                                value=""
                                {% if couleur is same as(null) or couleur == '' %}checked{% endif %}
                            >
                            <label for="couleurAll">Toutes</label>
                        </li>
                    </ul>
                </div>

                <div class="filter-group">
                    <p class="filter-group-title">Prix</p>
                    <div class="filter-price">
                        <input type="number" name="prix_min" placeholder="Min" value="{{ prix_min }}">
                        <input type="number" name="prix_max" placeholder="Max" value="{{ prix_max }}">
                    </div>
                </div>

                <button class="btn-primary">Appliquer</button>
            </form>

            <a href="{{ base }}/encheres/archivees" class="btn-reset">Réinitialiser</a>

        </aside>

        <div class="enchere-content">
            <h1 class="section__title">Enchères archivées</h1>

            {% if encheres is not empty %}
                <div class="enchere-grid">

                    {% for e in encheres %}
                        <article class="enchere-card">

                        {% if e.image_principale %}
                            <div class="enchere-card__image">
                                <img src="{{ base }}/img/{{ e.image_principale }}" alt="{{ e.timbre_nom }}">
                            </div>
                        {% endif %}

                        <div class="enchere-card__body">
                            <h2 class="enchere-card__title">{{ e.timbre_nom }}</h2>

                            <p><strong>Prix plancher :</strong> {{ e.prix_plancher }}$</p>
                            <p><strong>Ouverture :</strong> {{ e.date_ouverture | date("d/m/Y") }}</p>
                            <p><strong>Fermeture :</strong> {{ e.date_fermeture | date("d/m/Y") }}</p>

                            <a href="{{ base }}/encheres/fiche?id={{ e.idenchere }}" class="btn-primary enchere-card__btn">Voir détails</a>
                        </div>

                        </article>
                    {% endfor %}

                </div>
            {% else %}
                <p>Aucune enchère archivées pour le moment.</p>
            {% endif %}
        </div>

    </div>
</section>

{% include 'layouts/footer.php' %}
