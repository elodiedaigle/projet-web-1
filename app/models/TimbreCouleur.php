<?php
namespace App\Models;

/*
=======================================================================
TIMBRE COULEUR : Représente la liaisons entre un timbre et ses couleurs
=======================================================================
*/
class TimbreCouleur extends CRUD {
    protected $table = 'timbre_has_couleur';
    protected $primaryKey = null;
    protected $fillable = [
        'timbre_idtimbre',
        'Couleur_idCouleur'
    ];
}
