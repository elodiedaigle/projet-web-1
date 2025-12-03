<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ title ?? 'Stampee' }}</title>
    <link rel="stylesheet" href="{{ base }}/assets/css/style.css">
    
    <script src="{{ base }}/js/validation-register.js" defer></script>
    <script src="{{ base }}/js/validation-login.js" defer></script>
    <script src="{{ base }}/js/menu-burger.js" defer></script>
</head>
<body>

<header class="site-header">
    <div class="container header-inner">

        <!-- Logo -->
         <a href="{{ base }}/" class="logo">
            <img src="{{ base }}/assets/img/logo-stampee.png" alt="Logo Stampee">
         </a>

         <!-- Navigation -->
          <nav class="nav">

            <ul class="nav__left">
                <li class="{% if currentPath == '/' %}active{% endif %}">
                    <a href="{{ base }}/">Accueil</a>
                </li>
            </ul>

            <ul class="nav__right">
                {% if not session.user_id %}
                <li class="{% if currentPath starts with '/register' %}active{% endif %}">
                    <a href="{{ base }}/register">Devenir membre</a>
                </li>

                <li class="{% if currentPath starts with '/login' %}active{% endif %}">
                    <a href="{{ base }}/login">Connexion</a>
                </li>

                {% else %}
                <li>
                    <a href="{{ base }}/logout">Déconnexion</a>
                </li>
                {% endif %} 
            </ul>

          </nav>

          <!-- Navigation mobile : Menu burger -->
            <div class="burger">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <nav class="nav-mobile">
                <a href="{{ base }}/">Accueil</a>
                {% if not session.user_id %}
                    <a href="{{ base }}/register">Devenir membre</a>
                    <a href="{{ base }}/login">Connexion</a>
                {% else %}
                    <a href="{{ base }}/logout">Déconnexion</a>
                {% endif %}
            </nav>

    </div>
</header>

<main class="main-content">