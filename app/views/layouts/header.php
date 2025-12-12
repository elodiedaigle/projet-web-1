<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ title ?? 'Stampee' }}</title>
    <link rel="stylesheet" href="{{ base }}/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    
    <script src="{{ base }}/js/validation-register.js" defer></script>
    <script src="{{ base }}/js/validation-login.js" defer></script>
    <script src="{{ base }}/js/validation-enchere-create.js" defer></script>
    <script src="{{ base }}/js/menu-burger.js" defer></script>
    <script src="{{ base }}/js/fiche-images.js" defer></script>
</head>
<body>

<header class="site-header">
    <div class="container header-inner">

         <a href="{{ base }}/" class="logo">
            <img src="{{ base }}/assets/img/logo-stampee.png" alt="Logo Stampee">
         </a>

          <nav class="nav">

            <ul class="nav__left">
                <li>
                    <a href="{{ base }}/">Accueil</a>
                </li>

                <li class="nav-dropdown">
                    
                    <span class="nav-dropdown__label">Enchères ▾</span>

                    <ul class="nav-dropdown__menu">
                        <li>
                            <a href="{{ base }}/encheres/actives">Enchères actives</a>
                        </li>

                        <li>
                            <a href="{{ base }}/encheres/archivees">Enchères archivées</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav__right">
                {% if not session.user_id %}
                <li>
                    <a href="{{ base }}/register">Devenir membre</a>
                </li>

                <li>
                    <a href="{{ base }}/login">Connexion</a>
                </li>

                {% else %}
                <li>
                    <a href="{{ base }}/encheres/create">Créer une enchère</a>
                </li>

                <li>
                    <a href="{{ base }}/logout">Déconnexion</a>
                </li>
                {% endif %} 
            </ul>

          </nav>

            <div class="burger">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <nav class="nav-mobile">
                <a href="{{ base }}/">Accueil</a>

                <span class="nav-section-title">Enchères</span>
                <a href="{{ base }}/encheres/actives" class="nav-subitem">• Actives</a>
                <a href="{{ base }}/encheres/archivees" class="nav-subitem">• Archivées</a>

                {% if not session.user_id %}
                    <a href="{{ base }}/register">Devenir membre</a>
                    <a href="{{ base }}/login">Connexion</a>
                {% else %}
                    <a href="{{ base }}/encheres/create" class="nav-subitem">• Créer une enchère</a>
                    <a href="{{ base }}/logout">Déconnexion</a>
                {% endif %}
            </nav>
    </div>
</header>
