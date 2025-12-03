<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ title ?? 'Stampee' }}</title>
    <link rel="stylesheet" href="{{ base }}/assets/css/style.css">
    
    <script src="{{ base }}/js/validation-register.js" defer></script>
    <script src="{{ base }}/js/validation-login.js" defer></script>

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

            <ul class="nav-list">
                <li class="nav-left {% if currentPath == '/' %}active{% endif %}">
                    <a href="{{ base }}/">Accueil</a>
                </li>

                {% if not session.user_id %}
                <li class="nav-right {% if currentPath starts with '/register' %}active{% endif %}">
                    <a href="{{ base }}/register">Inscription</a>
                </li>

                <li class="nav-right {% if currentPath starts with '/login' %}active{% endif %}">
                    <a href="{{ base }}/login">Connexion</a>
                </li>

                {% else %}
                <li class="nav-right">
                    <a href="{{ base }}/logout">Déconnexion</a>
                </li>
                {% endif %}

            </ul>

          </nav>

    </div>
</header>

<main class="main-content">