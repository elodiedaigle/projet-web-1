{% include 'layouts/header.php' %}

<section class="section section--hero">
    <div class="container">
        <h1 class="section__title section__title--hero">Enchères Stampee</h1>
        <p class="section__text section__text--hero">
            La plateforme d'enchères dédiée aux passionnés de philatélie. Explorez un univers où chaque timbre raconte une histoire, 
            chaque collection révèle un voyage, et chaque enchère ouvre une nouvelle aventure.
        </p>
    </div>
</section>

{% if favoris is not empty %}
<section class="section">
    <div class="container">
        <h2 class="section__title">Enchères vedettes</h2>

        <div class="enchere-grid">
            {% for e in favoris %}
                <article class="enchere-card">

                    {% if e.image_principale %}
                        <div class="enchere-card__image">
                            <img src="{{ base }}/img/{{ e.image_principale }}" alt="{{ e.timbre_nom }}">
                        </div>
                    {% endif %}

                    <div class="enchere-card__body">
                        <h3 class="enchere-card__title">{{ e.timbre_nom }}</h3>
                            <p><strong>Prix plancher :</strong> {{ e.prix_plancher }}$</p>
                            <p><strong>Ouverture :</strong> {{ e.date_ouverture | date("d/m/Y") }}</p>
                            <p><strong>Fermeture :</strong> {{ e.date_fermeture | date("d/m/Y") }}</p>

                        <a href="{{ base }}/encheres/fiche?id={{ e.idenchere }}" class="btn-primary enchere-card__btn">Voir détails</a>
                    </div>

                </article>
            {% endfor %}
        </div>
    </div>
</section>
{% endif %}

<section class="section section--panel">
    <div class="container">
        <div class="section__block">
            <h2 class="section__title">Lord Reginald Stampee III</h2>
            <p class="section__text">
                Collectionneur excentrique, historien amateur et explorateur d'archives oubliées,
                Lord Reginald Stampee III a bâti au fil des ans l'une des plus riches collections
                philatéliques du Commonwealth.
            </p>
            <p class="section__text">
                À travers cette plateforme, il souhaite partager sa passion, mettre en lumière des 
                pièces rares et permettre à d'autres amateurs de faire partie de cette grande famille.
            </p>
        </div>
    </div>
</section>

{% if encheresActives is not empty %}
<section class="section">
    <div class="container">
        <h2 class="section__title">Enchères en cours</h2>

        <div class="enchere-grid">
            {% for e in encheresActives %}
                <article class="enchere-card">

                    {% if e.image_principale %}
                        <div class="enchere-card__image">
                            <img src="{{ base }}/img/{{ e.image_principale }}" alt="{{ e.timbre_nom }}">
                        </div>
                    {% endif %}

                    <div class="enchere-card__body">
                        <h3 class="enchere-card__title">{{ e.timbre_nom }}</h3>
                        <p><strong>Prix plancher :</strong> {{ e.prix_plancher }}$</p>
                        <p><strong>Fermeture :</strong> {{ e.date_fermeture | date("d/m/Y") }}</p>

                        <a href="{{ base }}/encheres/fiche?id={{ e.idenchere }}"
                           class="btn-primary enchere-card__btn">
                            Voir détails
                        </a>
                    </div>

                </article>
            {% endfor %}
        </div>
    </div>
</section>
{% endif %}


{% include 'layouts/footer.php' %}
