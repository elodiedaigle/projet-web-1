<?php
namespace App\Models;

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
