<?php
namespace App\Models;

/*
==========================================
COULEUR : Représente une couleur de timbre
==========================================
*/
class Couleur extends CRUD {
    protected $table = 'couleur';
    protected $primaryKey = 'idCouleur';
    protected $fillable = ['nom'];
}
