<?php
namespace App\Models;

class TimbreCondition extends CRUD {
    protected $table = 'timbre_condition';
    protected $primaryKey = 'idTimbreCondition';
    protected $fillable = ['nom'];
}
