<?php
namespace App\Models;

class Utilisateur extends CRUD {
    protected $table = 'utilisateur';
    protected $primaryKey = 'idutilisateur';
    protected $fillable = ['nom', 'prenom', 'courriel', 'password_hash'];

    /* 
    =========================================================
    FIND BY EMAIL : Récupérer un utilisateur par son courriel
    =========================================================
    */

    public function findByEmail($courriel) {
        $sql = "SELECT * FROM $this->table WHERE courriel = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$courriel]);
        return $stmt->fetch();
    }
}