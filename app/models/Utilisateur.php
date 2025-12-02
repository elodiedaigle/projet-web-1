<?php
namespace App\Models;

class Utilisateur extends CRUD {
    protected $table = 'utilisateur';
    protected $primaryKey = 'idutilisateur';
    protected $fillable = ['nom', 'prenom', 'courriel', 'password_hash'];
}