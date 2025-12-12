<?php
namespace App\Providers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View {

    /* 
    =============================================
    RENDER : Charger et afficher une vue via Twig
    =============================================
    */

    public static function render($template, $data = []){

        // Indique où se trouve les fichiers de vues
        $loader = new FilesystemLoader(__DIR__ . '/../views');

        // Initialise Twig
        $twig = new Environment($loader);

        // Variables accessibles dans toutes les vues
        $twig->addGlobal('base', BASE);
        $twig->addGlobal('session', $_SESSION);

        // Affiche la vue demandée
        echo $twig->render($template . '.php', $data);
    }

    /* 
    =========================================
    REDIRECT : Rediriger vers une autre route
    =========================================
    */

    public static function redirect($url)
    {
        header("Location: " . BASE . $url);
        exit;
    }
}