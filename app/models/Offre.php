<?php
namespace App\Models;

class Offre extends CRUD {
    protected $table = 'offre';
    protected $primaryKey = 'idoffre';
    protected $fillable = [
        'montant_offert',
        'date_offre',
        'utilisateur_idutilisateur',
        'enchere_idenchere'
    ];

    /* 
    =================================================
    GET BY ENCHERE : Récupérer les offres par enchère
    =================================================
    */

    public function getByEnchere($idEnchere) {
        $sql = "SELECT o.*, u.prenom, u.nom
                FROM offre o
                INNER JOIN utilisateur u 
                    ON u.idutilisateur = o.utilisateur_idutilisateur
                WHERE o.enchere_idenchere = ?
                ORDER BY o.montant_offert DESC";

        $stmt = $this->prepare($sql);
        $stmt->execute([$idEnchere]);
        return $stmt->fetchAll();
    }

    /* 
    =====================================================================
    GET HIGHEST BID : Récupérer la plus grosse offre actuelle par enchère
    =====================================================================
    */

    public function getHighestBid($idEnchere) {
        $sql = "SELECT MAX(montant_offert) AS max FROM offre WHERE enchere_idenchere = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$idEnchere]);
        return $stmt->fetch()['max'] ?? null;
    }
}