<?php
namespace App\Models;

class TimbreCouleur extends CRUD {
    protected $table = 'timbre_has_couleur';
    protected $primaryKey = null;
    protected $fillable = [
        'timbre_idtimbre',
        'Couleur_idCouleur'
    ];
}
