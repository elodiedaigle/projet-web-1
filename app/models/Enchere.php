<?php
namespace App\Models;

class Enchere extends CRUD {
    protected $table = 'enchere';
    protected $primaryKey = 'idenchere';
    protected $fillable = [
        'date_ouverture',
        'date_fermeture',
        'prix_plancher',
        'coup_coeur',
        'timbre_idtimbre',
        'utilisateur_idutilisateur'
    ];

    public function getActives() {
        $sql = "SELECT 
                    e.idenchere,
                    e.date_ouverture,
                    e.date_fermeture,
                    e.prix_plancher,
                    t.nom AS timbre_nom,
                    i.url AS image_principale

                FROM enchere e
                INNER JOIN timbre t 
                    ON t.idtimbre = e.timbre_idtimbre

                LEFT JOIN timbre_image i 
                    ON i.timbre_idtimbre = t.idtimbre
                    AND i.type_image = 'principale'

                WHERE e.date_fermeture > NOW()
                ORDER BY e.date_fermeture ASC";

        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    public function findFull($id) {
    $sql = "SELECT 
            e.idenchere,
            e.date_ouverture,
            e.date_fermeture,
            e.prix_plancher,
            e.coup_coeur,

            t.idtimbre,
            t.nom AS timbre_nom,
            t.annee_publication,
            t.tirage,
            t.dimensions,
            t.certifie,

            tc.nom AS condition_nom,
            p.nom AS pays_nom

            FROM enchere e
            INNER JOIN timbre t ON t.idtimbre = e.timbre_idtimbre
            LEFT JOIN timbre_condition tc ON tc.idTimbreCondition = t.timbre_condition_idTimbreCondition
            LEFT JOIN pays p ON p.idPays = t.Pays_idPays
            WHERE e.idenchere = ?
            LIMIT 1";

    $stmt = $this->prepare($sql);
    $stmt->execute([$id]);
    $enchere = $stmt->fetch();

    if (!$enchere) {
        return null;
    }

    $enchere['est_active'] = strtotime($enchere['date_fermeture']) > time();
    return $enchere;
    }


    public function getImages($timbreId) {
        $sql = "SELECT url, type_image 
                FROM timbre_image 
                WHERE timbre_idtimbre = ?";

        $stmt = $this->prepare($sql);
        $stmt->execute([$timbreId]);
        return $stmt->fetchAll();
    }
}