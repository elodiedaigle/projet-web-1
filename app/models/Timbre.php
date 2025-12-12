<?php
namespace App\Models;

/*
=============================
TIMBRE : Représente un timbre
=============================
*/
class Timbre extends CRUD {
    protected $table = 'timbre';
    protected $primaryKey = 'idtimbre';
    protected $fillable = [
        'nom',
        'annee_publication',
        'tirage',
        'dimensions',
        'certifie',
        'Pays_idPays',
        'timbre_condition_idTimbreCondition'
    ];
}
