<?php
namespace App\Controllers;

use App\Models\Enchere;
use App\Providers\View;

class EnchereController
{
    public function actives()
    {
        $encheres = (new Enchere())->getActives();

        return View::render('encheres/actives', [
            'encheres' => $encheres
        ]);
    }
}
