<?php 
namespace App\Controllers;
use App\Providers\View;
use App\Providers\Validator;
use App\Models\Utilisateur;

class AuthController {

    // Afficher le formulaire d'inscription
    public function register() {
        return View::render('auth/register');
    }

    // Traiter le formulaire d'inscription
    public function registerPost($post = []) {
        $prenom = trim($post['prenom'] ?? '');
        $nom = trim($post['nom'] ?? '');
        $courriel = trim($post['courriel'] ?? '');
        $motDePasse = $post['mot_de_passe'] ?? '';
        $motDePasseConfirmation = $post['mot_de_passe_confirmation'];

        // Validations
        $validator = new Validator();

            // Champs requis
            $validator->field('prenom', $prenom)->required();
            $validator->field('nom', $nom)->required();
            $validator->field('courriel', $courriel)->required()->email();
            $validator->field('mot_de_passe', $motDePasse)->required();
            $validator->field('mot_de_passe_confirmation', $motDePasseConfirmation)->required()->same('mot_de_passe', $motDePasse);

            // Courriel unique
            $validator->field('courriel', $courriel)->unique('Utilisateur');

            // En cas d'erreur, retourner au formulaire
            if (!$validator->isSuccess()) {
                return View::render(
                    'auth/register', 
                    ['erreurs' => $validator->getErrors(), 
                    'old' => $post]);
            }

            // Quand tout est validé, hash le mot de passe et insérer
            $hash = password_hash($motDePasse, PASSWORD_DEFAULT);

            $utilisateur = new Utilisateur();

            $utilisateur->insert([
                'prenom' => $prenom,
                'nom' => $nom,
                'courriel' => $courriel,
                'password_hash' => $hash
            ]);

            // Redirection au login
            return View::redirect('/login');
    }

    // Afficher le formulaire de connexion
    public function login() {
        return View::render('auth/login');
    }

    // Traiter le formulaire de connexion
    public function loginPost($post = []) {
        $courriel = trim($post['courriel'] ?? '');
        $motDePasse = $post['mot_de_passe'] ?? '';

        // Validations
        $validator = new Validator();

            // Champs requis
            $validator->field('courriel', $courriel)->required()->email();
            $validator->field('mot_de_passe', $motDePasse)->required();
        
            // En cas d'erreur, retourner au formulaire
            if (!$validator->isSuccess()) {
                return View::render(
                    'auth/login', 
                    ['erreurs' => $validator->getErrors(), 
                    'old' => $post]);
            }

            // Vérifier que l'utilisateur existe
            $u = new Utilisateur();
            $user = $u->findByEmail($courriel);

            if (!$user || !password_verify($motDePasse, $user['password_hash'])) {
                return View::render('auth/login', [
                    'erreurs' => ['Courriel ou mot de passe invalide.'],
                    'old' => $post
                ]);
            }

            // Quand tout est validé, créer la session
            $_SESSION ['user_id'] = $user['idutilisateur'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_courriel'] = $user['courriel'];

            return View::redirect('/');
    }

    // Déconnexion
    public function logout() {
        session_destroy();
        return View::redirect('/');
    }
}