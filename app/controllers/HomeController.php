<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Enchere;
use App\Models\Favori;

class HomeController {

    /* 
    ==================================
    INDEX : Afficher la page d'accueil
    ==================================
    */

    public function index() {

        // Initialiser le tableau de favoris
        $favoris = [];

        // Si connecté, récupérer ses favoris à lui
        if (isset($_SESSION['user_id'])) {
            $favoriModel = new Favori();
            $favoris = $favoriModel->getByUser($_SESSION['user_id']);
        }

        // Récupérer les enchères actives
        $enchereModel = new Enchere();
        $encheresActives = $enchereModel->getActives();

        // Limiter l'aperçu pour la page d'accueil
        $encheresActives = array_slice($encheresActives, 0, 4);

        return View::render('accueil/index', [
            'encheresActives' => $encheresActives,
            'favoris' => $favoris
        ]);
    }
}
