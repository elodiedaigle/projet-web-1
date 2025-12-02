<?php 
namespace App\Controllers;
use App\Providers\View;
use App\Models\Utilisateur;

class AuthController {

    // Afficher le formulaire d'inscription
    public function register() {

        return View::render('auth/register');
    }

    // Traiter le formulaire d'inscription
    public function registerPost($post = []) {
        $nom = trim($post['nom'] ?? '');
        $prenom = trim($post['prenom'] ?? '');
        $courriel = trim($post['courriel'] ?? '');
        $motDePasse = trim($post['mot_de_passe'] ?? '');
        $moteDePasseConfirmation = trim($post['mot_de_passe_confirmation']);

        // Logique de validation à ajouter sous peu
    }

    // Afficher le formulaire de connexion - À faire plus tard
    public function login() {

        return View::render('auth/login');
    }

    // Traiter le formulaire de connextion - À faire plus tard
    public function loginPost($post = []) {

    }

    // Déconnexion - À faire plus tard
    public function logout() {

    }
}