<?php
namespace App\Controllers;

use App\Models\Enchere;
use App\Providers\View;

class EnchereController
{
    public function actives(){
        $encheres = (new Enchere())->getActives();

        return View::render('encheres/actives', [
            'encheres' => $encheres
        ]);
    }

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

        $images = $model->getImages($enchere['idtimbre']);

        $imagePrincipale = null;
        $imagesSecondaires = [];

        foreach ($images as $img) {
            if ($img['type_image'] === 'principale') {
                $imagePrincipale = $img['url'];
            } else {
                $imagesSecondaires[] = $img['url'];
            }
        }

        if (!$imagePrincipale) {
            $imagePrincipale = 'placeholder.png';
        }

        return View::render('encheres/fiche', [
            'enchere' => $enchere,
            'imagePrincipale' => $imagePrincipale,
            'imagesSecondaires' => $imagesSecondaires
        ]);
    }
}
