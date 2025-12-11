{% include 'layouts/header.php' %}

<section class="section">
    <div class="container enchere-layout">

        <aside class="enchere-filters">
            {# Filtres à ajouter dans le sprint 3 #}
        </aside>

        <div class="enchere-content">
            <h1 class="section__title">Enchères actives</h1>

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
                            <p><strong>Ouverture :</strong> {{ e.date_ouverture }}</p>
                            <p><strong>Fermeture :</strong> {{ e.date_fermeture }}</p>

                            <a href="{{ base }}/encheres/fiche?id={{ e.idenchere }}" class="btn-primary enchere-card__btn">
                                Voir détails
                            </a>
                        </div>

                        </article>
            {% endfor %}


                </div>
            {% else %}
                <p>Aucune enchère active pour le moment.</p>
            {% endif %}
        </div>

    </div>
</section>

{% include 'layouts/footer.php' %}
