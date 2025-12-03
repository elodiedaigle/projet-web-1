</main>

<footer class="site-footer">
    <div class="container footer-inner">

        <!-- Colonne 1 : Logo et description -->
        <div class="footer-col footer-brand">
            <img src="{{ base }}/assets/img/logo-stampee.png" alt="Logo Stampee" class="footer-logo">
            <p class="footer-description">
                La référence des passionnés de philatélie. Découvrez, explorez et enchérissez dans un univers raffiné.
            </p>
        </div>

        <!-- Colonne 2 : Liens utiles -->
        <div class="footer-col footer-links">
            <h3 class="footer-title">Navigation</h3>
            <ul>
                <li><a href="{{ base }}/">Accueil</a></li>
                <li><a href="{{ base }}/login">Connexion</a></li>
                <li><a href="{{ base }}/register">Inscription</a></li>
            </ul>
        </div>

        <!-- Colonne 3 : Contact (sans formulaire car pas encore prêt) -->
        <div class="footer-col footer-contact">
            <h3 class="footer-title">Contact</h3>
            <ul>
                <li><strong>Angleterre :</strong> +44 20 1234 5678</li>
                <li><strong>Canada :</strong> +1 514 123 4567</li>
                <li><strong>États-Unis :</strong> +1 202 987 6543</li>
                <li><strong>Australie :</strong> +61 2 3456 7890</li>
                <li><strong>Courriel :</strong> <a href="mailto:info@stampee.com">info@stampee.com</a></li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© {{ "now"|date("Y") }} Stampee — Tous droits réservés.</p>
    </div>
</footer>

</body>
</html>
