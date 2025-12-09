<?php
namespace App\Models;

class Enchere extends CRUD {
    protected $table = 'enchere';
    protected $primaryKey = 'idenchere';
    protected $fillable = [
        'date_ouverture',
        'date_fermeture',
        'prix_plancher',
        'statut',
        'timbre_idtimbre'
    ];

    public function getActives() {
        $sql = "SELECT e.idenchere, e.date_ouverture, e.date_fermeture, e.prix_plancher, t.nom AS timbre_nom
                FROM enchere e
                INNER JOIN timbre t ON t.idtimbre = e.timbre_idtimbre
                WHERE e.date_fermeture > NOW()
                ORDER BY e.date_fermeture ASC;
        ";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}