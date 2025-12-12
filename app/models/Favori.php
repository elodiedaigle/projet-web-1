<?php
namespace App\Models;

class Favori extends CRUD
{
    protected $table = 'vedette';
    protected $primaryKey = null;
    protected $fillable = [
        'utilisateur_idutilisateur',
        'timbre_idtimbre'
    ];

    /* 
    =====================================================================
    EXISTS : Vérifier si un timbre est déjà en favori pour un utilisateur
    =====================================================================
    */

    public function exists($utilisateurId, $timbreId)
    {
        $sql = "SELECT * 
                FROM vedette
                WHERE utilisateur_idutilisateur = ?
                AND timbre_idtimbre = ?
                LIMIT 1";

        $stmt = $this->prepare($sql);
        $stmt->execute([$utilisateurId, $timbreId]);

        return $stmt->fetch();
    }

    /* 
    =============================================================
    ADD : Ajouter un favori
    =============================================================
    */

    public function add($utilisateurId, $timbreId)
    {
        return $this->insert([
            'utilisateur_idutilisateur' => $utilisateurId,
            'timbre_idtimbre' => $timbreId
        ]);
    }

    /* 
    =============================================
    DELETE BY USER AND TIMBRE : Retirer un favori
    =============================================
    */

    public function deleteByUserAndTimbre($utilisateurId, $timbreId)
    {
        $sql = "DELETE FROM vedette
                WHERE utilisateur_idutilisateur = ?
                AND timbre_idtimbre = ?";

        $stmt = $this->prepare($sql);
        $stmt->execute([$utilisateurId, $timbreId]);
    }

    /* 
    ====================================================
    GET BY USER : Récupérer les favoris d'un utilisateur
    ====================================================
    */

    public function getByUser($utilisateurId)
    {
        $sql = "SELECT 
                    e.idenchere,
                    e.prix_plancher,
                    e.date_fermeture,
                    t.nom AS timbre_nom,
                    i.url AS image_principale
                FROM vedette v
                INNER JOIN timbre t 
                    ON t.idtimbre = v.timbre_idtimbre
                INNER JOIN enchere e 
                    ON e.timbre_idtimbre = t.idtimbre
                LEFT JOIN timbre_image i 
                    ON i.timbre_idtimbre = t.idtimbre
                    AND i.type_image = 'principale'
                WHERE v.utilisateur_idutilisateur = ?";

        $stmt = $this->prepare($sql);
        $stmt->execute([$utilisateurId]);

        return $stmt->fetchAll();
    }
}
