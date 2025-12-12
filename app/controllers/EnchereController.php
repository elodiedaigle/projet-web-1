<?php
namespace App\Controllers;

use App\Models\Enchere;
use App\Models\Timbre;
use App\Models\TimbreImage;
use App\Models\Couleur;
use App\Models\TimbreCouleur;
use App\Models\TimbreCondition;
use App\Models\TimbrePays;
use App\Models\Offre;
use App\Models\Favori;
use App\Providers\View;
use App\Providers\Validator;

class EnchereController
{
    /* 
    ==============================================
    ACTIVES : Liste et filtre des enchères actives
    ==============================================
    */

    public function actives($query = []){
        $enchereModel = new Enchere();

        // Récupérer les filtres activés
        $filtres = [
            'pays' => $query['pays'] ?? null,
            'annee'=> $query['annee'] ?? null,
            'condition' => $query['condition'] ?? null,
            'certifie' => $query['certifie']  ?? null,
            'prix_min' => $query['prix_min']  ?? null,
            'prix_max' => $query['prix_max']  ?? null
        ];

        // Résultats
        $encheres = $enchereModel->getActivesFiltres($filtres);

        // Charger les conditions
        $conditionModel = new TimbreCondition();
        $conditions = $conditionModel->select();

        return View::render('encheres/actives', [
            'encheres' => $encheres,
            'conditions'=> $conditions
        ]);
    }

    /* 
    ==================================================
    ARCHIVEES : Liste et filtre des enchères archivées
    ==================================================
    */

    public function archivees($query = []){
        $enchereModel = new Enchere();

        // Récupérer les filtres activés
        $filtres = [
            'pays' => $query['pays'] ?? null,
            'annee' => $query['annee'] ?? null,
            'condition' => $query['condition'] ?? null,
            'certifie' => $query['certifie']  ?? null,
            'prix_min' => $query['prix_min']  ?? null,
            'prix_max' => $query['prix_max']  ?? null
        ];

        // Résultats
        $encheres = $enchereModel->getArchiveesFiltres($filtres);

        // Charger les conditions
        $conditionModel = new TimbreCondition();
        $conditions = $conditionModel->select();

        return View::render('encheres/archivees', [
            'encheres'   => $encheres,
            'conditions' => $conditions
        ]);
    }

    /* 
    ===========================================
    FICHES : Afficher les détails d'une enchère
    ===========================================
    */

    public function fiche($query = []){
        if (!isset($query['id']) || !ctype_digit($query['id'])) {
            return View::redirect('/encheres/actives');
        }

        $id = (int)$query['id'];
        $model = new Enchere();
        $enchere = $model->findFull($id);

        if (!$enchere) {
            return View::redirect('/encheres/actives');
        }

        // Charger l'état favori
        $estFavori = false;

        if (isset($_SESSION['user_id'])) {
            $favoriModel = new Favori();
            $favori = $favoriModel->exists($_SESSION['user_id'], $enchere['idtimbre']);
            $estFavori = $favori ? true : false;
        }

        // Charger les images
        $imgModel = new TimbreImage();
        $images = $imgModel->getImages($enchere['idtimbre']);

        // Images principales vs secondaires
        $imagePrincipale = null;
        $imagesSecondaires = [];

        foreach ($images as $img) {
            if ($img['type_image'] === 'principale') {
                $imagePrincipale = $img['url'];
            } else {
                $imagesSecondaires[] = $img['url'];
            }
        }

        // Charger les offres
        $offreModel = new Offre();
        $offres = $offreModel->getByEnchere($id);
        $maxOffer = $offreModel->getHighestBid($id);

        if ($maxOffer === null) {
            $prixMin = $enchere['prix_plancher'];
        } else {
            $prixMin = $maxOffer + 1;
        }

        return View::render('encheres/fiche', [
            'enchere' => $enchere,
            'imagePrincipale' => $imagePrincipale,
            'imagesSecondaires' => $imagesSecondaires,
            'offres' => $offres,
            'prixMin' => $prixMin,
            'est_favori' => $estFavori
        ]);
    }

     /* 
    ========================================================
    TOGGLE FAVORI : Ajouter ou retirer une enchère en favori
    ========================================================
    */

    public function toggleFavori($post = []) {

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            return View::redirect('/login');
        }

        // Récupérer les informations nécessaires
        $utilisateurId = $_SESSION['user_id'];
        $enchereId = (int)($post['enchere_id'] ?? 0);
        $timbreId = (int)($post['timbre_id'] ?? 0);

        // Validations
        if ($enchereId === 0 || $timbreId === 0) {
            return View::redirect('/encheres/actives');
        }

        // Ajouter ou retirer le favori selon l'état actuel
        $favoriModel = new Favori();
        $existe = $favoriModel->exists($utilisateurId, $timbreId);

        if ($existe) {
            $favoriModel->deleteByUserAndTimbre($utilisateurId, $timbreId);
        } else {
            $favoriModel->add($utilisateurId, $timbreId);
        }

        return View::redirect('/encheres/fiche?id=' . $enchereId);
    }


    /* 
    =====================================================
    CREATE : Afficher le formulaire de création d'enchère
    =====================================================
    */

    public function create() {
        $couleurModel = new Couleur();
        $couleurs = $couleurModel->select();
        $conditionModel = new TimbreCondition();
        $conditions = $conditionModel->select();

        return View::render('encheres/create', [
            'couleurs' => $couleurs,
            'conditions' => $conditions
        ]);
    }

    /* 
    =========================================================
    CREATE POST : Gestion du formulaire de création d'enchère
    =========================================================
    */

    public function createPost($post = [], $files = []) {

        // Validations
        $validator = new Validator();

        // Champs requis
        $validator->field('nom', $post['nom'] ?? '')->required();
        $validator->field('annee_publication', $post['annee_publication'] ?? '')->required();
        $validator->field('tirage', $post['tirage'] ?? '')->required();
        $validator->field('dimensions', $post['dimensions'] ?? '')->required();
        $validator->field('pays', $post['pays'] ?? '')->required();
        $validator->field('condition', $post['condition'] ?? '')->required();
        $validator->field('prix_plancher', $post['prix_plancher'] ?? '')->required();
        $validator->field('date_ouverture', $post['date_ouverture'] ?? '')->required();
        $validator->field('date_fermeture', $post['date_fermeture'] ?? '')->required();

        if (!isset($files['image_principale']) || $files['image_principale']['error'] !== 0) {
            $validator->field('image_principale', '')->required();
        }

        // En cas d'erreur, retourner au formulaire
        if (!$validator->isSuccess()) {

            $couleurModel = new Couleur();
            $couleurs = $couleurModel->select();

            $conditionModel = new TimbreCondition();
            $conditions = $conditionModel->select();

            return View::render('encheres/create', [
                'erreurs' => $validator->getErrors(),
                'old' => $post,
                'couleurs' => $couleurs,
                'conditions' => $conditions
            ]);
        }

        // Quand tout est validé, créer le timbre
        $timbreModel = new Timbre();
        $paysBrut = trim($post['pays']);
        $paysNettoye = ucfirst(strtolower($paysBrut));
        $paysModel = new TimbrePays();
        $paysExistant = $paysModel->findByNom($paysNettoye);

        // Nettoyer le nom du pays et vérifier s’il existe déjà
        if ($paysExistant) {
            $idPays = $paysExistant['idPays'];
        } else {
            $idPays = $paysModel->insert([
                'nom' => $paysNettoye
            ]);
        }

        $timbreId = $timbreModel->insert([
            'nom' => $post['nom'],
            'annee_publication' => $post['annee_publication'],
            'tirage' => $post['tirage'],
            'dimensions' => $post['dimensions'],
            'certifie' => $post['certifie'] ?? 0,
            'Pays_idPays' => $idPays,
            'timbre_condition_idTimbreCondition' => $post['condition']
        ]);

        // Ajouter les couleurs associées
        if (!empty($post['couleurs']) && is_array($post['couleurs'])) {
            $timbreCouleurModel = new TimbreCouleur();

            foreach ($post['couleurs'] as $idCouleur) {
                $timbreCouleurModel->insert([
                    'timbre_idtimbre' => $timbreId,
                    'Couleur_idCouleur' => $idCouleur
                    ]);
                }
            }

        // Puis uploader l'image
        $filenamePrincipale = uniqid('img_') . '.jpg';
            move_uploaded_file(
            $files['image_principale']['tmp_name'],
            __DIR__ . '/../../public/img/' . $filenamePrincipale
        );

        $imgModel = new TimbreImage();
        $imgModel->insert([
            'url' => $filenamePrincipale,
            'type_image' => 'principale',
            'timbre_idtimbre' => $timbreId
        ]);   

        // Et les images secondaires s'il y a
        if (isset($files['images_secondaires']) && is_array($files['images_secondaires']['name'])) {

            foreach ($files['images_secondaires']['name'] as $index => $name) {

                if ($files['images_secondaires']['error'][$index] !== 0) {
                    continue;
                }

                $filename = uniqid('img_') . '.jpg';

                move_uploaded_file(
                    $files['images_secondaires']['tmp_name'][$index],
                    __DIR__ . '/../../public/img/' . $filename
                );

                $imgModel->insert([
                    'url' => $filename,
                    'type_image' => 'secondaire',
                    'timbre_idtimbre' => $timbreId
                ]);
            }   
        }

        // Finalement, créer l'enchère
        $enchereModel = new Enchere();
        $enchereId = $enchereModel->insert([
            'date_ouverture' => $post['date_ouverture'],
            'date_fermeture' => $post['date_fermeture'],
            'prix_plancher' => $post['prix_plancher'],
            'coup_coeur' => 0,
            'timbre_idtimbre' => $timbreId,
            'utilisateur_idutilisateur' => $_SESSION['user_id'] ?? 1
        ]);

        // Rediriger à la fiche créée
        return View::redirect('/encheres/fiche?id=' . $enchereId);
    }

    /* 
    ==========================================
    OFFRE POST : Gestion du formulaire d'offres
    ==========================================
    */

    public function offrePost($post = []){
        if (!isset($_SESSION['user_id'])) {
            return View::redirect('/login');
        }

        $enchereId = (int)($post['enchere_id'] ?? 0);
        $montant   = (float)($post['montant'] ?? 0);

        // Charger l'enchère
        $enchereModel = new Enchere();
        $enchere = $enchereModel->findFull($enchereId);

        if (!$enchere) {
            return View::redirect('/encheres/actives');
        }

        // Charger les images
        $imgModel = new TimbreImage();
        $images = $imgModel->getImages($enchere['idtimbre']);

        $imagePrincipale = null;
        $imagesSecondaires = [];

        foreach ($images as $img) {
            if ($img['type_image'] === 'principale') {
                $imagePrincipale = $img['url'];
            } else {
                $imagesSecondaires[] = $img['url'];
            }
        }

        // Charger les offres
        $offreModel = new Offre();
        $offres = $offreModel->getByEnchere($enchereId);

        // Validations
        if ($montant <= 0) {
            return View::render('encheres/fiche', [
                'enchere' => $enchere,
                'imagePrincipale' => $imagePrincipale,
                'imagesSecondaires' => $imagesSecondaires,
                'offres' => $offres,
                'erreur_offre' => "Veuillez entrer un montant valide."
            ]);
        }

        // Vérifier la meilleure offre
        $maxOffer = $offreModel->getHighestBid($enchereId);

        if ($maxOffer === null) {
            $prixMin = $enchere['prix_plancher'];
        } else {
            $prixMin = $maxOffer + 1;
        }

        if ($montant < $prixMin) {
            return View::render('encheres/fiche', [
                'enchere' => $enchere,
                'imagePrincipale' => $imagePrincipale,
                'imagesSecondaires' => $imagesSecondaires,
                'offres' => $offres,
                'erreur_offre' => "L'offre minimale est de {$prixMin}$"
            ]);
        }

        $offreModel->insert([
            'montant_offert' => $montant,
            'date_offre' => date('Y-m-d H:i:s'),
            'utilisateur_idutilisateur' => $_SESSION['user_id'],
            'enchere_idenchere' => $enchereId
        ]);

        return View::redirect('/encheres/fiche?id=' . $enchereId);
    }
}
