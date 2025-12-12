<?php
namespace App\Models;

/*
======================================================
TIMBRE CONDITION : Représente la condition d'un timbre
======================================================
*/
class TimbreCondition extends CRUD {
    protected $table = 'timbre_condition';
    protected $primaryKey = 'idTimbreCondition';
    protected $fillable = ['nom'];
}
