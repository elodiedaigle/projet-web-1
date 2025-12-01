<?php
namespace App\Providers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    public static function render($template, $data = [])
    {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $twig = new Environment($loader);

        echo $twig->render($template . '.php', $data);
    }

    public static function redirect($url)
    {
        header("Location: " . BASE . $url);
        exit;
    }
}