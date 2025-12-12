<?php
namespace App\Controllers;

use App\Providers\View;
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

        return View::render('accueil/index', [
            'favoris' => $favoris
        ]);
    }
}
