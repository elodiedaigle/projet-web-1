<?php
namespace App\Models;

class Couleur extends CRUD {
    protected $table = 'couleur';
    protected $primaryKey = 'idCouleur';
    protected $fillable = ['nom'];
}
