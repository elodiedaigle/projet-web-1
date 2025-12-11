<?php
namespace App\Controllers;

use App\Models\Enchere;
use App\Models\Timbre;
use App\Models\TimbreImage;
use App\Models\TimbreCouleur;
use App\Models\TimbreCondition;
use App\Models\TimbrePays;
use App\Providers\View;
use App\Providers\Validator;

class EnchereController
{
    // Afficher les enchères actives
    public function actives(){
        $encheres = (new Enchere())->getActives();

        return View::render('encheres/actives', [
            'encheres' => $encheres
        ]);
    }

    // Afficher les informations de la fiche 
    public function fiche($query = [])
{
        if (!isset($query['id']) || !ctype_digit($query['id'])) {
            return View::redirect('/encheres/actives');
        }

        $id = (int)$query['id'];
        $model = new Enchere();
        $enchere = $model->findFull($id);

        if (!$enchere) {
            return View::redirect('/encheres/actives');
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

        return View::render('encheres/fiche', [
            'enchere' => $enchere,
            'imagePrincipale' => $imagePrincipale,
            'imagesSecondaires' => $imagesSecondaires
        ]);
    }

    // Afficher le formulaire de création d'enchère
    public function create() {
        $couleurModel = new TimbreCouleur();
        $couleurs = $couleurModel->select();
        $conditionModel = new TimbreCondition();
        $conditions = $conditionModel->select();

        return View::render('encheres/create', [
            'couleurs' => $couleurs,
            'conditions' => $conditions
        ]);
    }

    // Traiter le formulaire de création d'enchères
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

            $couleurModel = new TimbreCouleur();
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

        // ajouter les couleurs associées
        if (!empty($post['couleurs']) && is_array($post['couleurs'])) {
            $timbreCouleurModel = new TimbreCouleur();

            foreach ($post['couleurs'] as $idCouleur) {
                $timbreCouleurModel->insert([
                    'timbre_idtimbre' => $timbreId,
                    'Couleur_idCouleur' => $idCouleur
                    ]);
                }
            }

        // puis uploader l'image
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

        // et les images secondaires s'il y a
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

        // et créer l'enchère
        $enchereModel = new Enchere();
        $enchereId = $enchereModel->insert([
            'date_ouverture' => $post['date_ouverture'],
            'date_fermeture' => $post['date_fermeture'],
            'prix_plancher' => $post['prix_plancher'],
            'coup_coeur' => 0,
            'timbre_idtimbre' => $timbreId,
            'utilisateur_idutilisateur' => $_SESSION['user_id'] ?? 1
        ]);

        // Redirection à la fiche créée
        return View::redirect('/encheres/fiche?id=' . $enchereId);
    }

    }
