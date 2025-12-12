<?php
namespace App\Controllers;

use App\Providers\View;

class HomeController {

    /* 
    ==================================
    INDEX : Afficher la page d'accueil
    ==================================
    */

    public function index()
    {
        return View::render('accueil/index', [
        ]);
    }
}
