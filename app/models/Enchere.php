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

    /* 
    =====================================================
    GET ACTIVES : Récupérer la liste des enchères actives
    =====================================================
    */

    public function getActives() {
        $sql = "SELECT 
                    e.idenchere,
                    e.date_ouverture,
                    e.date_fermeture,
                    e.prix_plancher,
                    t.nom AS timbre_nom,
                    i.url AS image_principale

                FROM enchere e
                INNER JOIN timbre t ON t.idtimbre = e.timbre_idtimbre

                LEFT JOIN timbre_image i ON i.timbre_idtimbre = t.idtimbre AND i.type_image = 'principale'

                WHERE e.date_fermeture > NOW()
                ORDER BY e.date_fermeture ASC";

        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    /* 
    =============================================================
    FIND FULL (ID) : Récupérer les infos détaillées d'une enchère
    =============================================================
    */

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

        // Calculer si l’enchère est toujours active selon sa date de fermeture
        $enchere['est_active'] = strtotime($enchere['date_fermeture']) > time();
        return $enchere;
        }

    /* 
    ====================================================
    GET IMAGES : Récupérer toutes les images d'un timbre
    ====================================================
    */

    public function getImages($timbreId) {
        $sql = "SELECT url, type_image 
                FROM timbre_image 
                WHERE timbre_idtimbre = ?";

        $stmt = $this->prepare($sql);
        $stmt->execute([$timbreId]);
        return $stmt->fetchAll();
    }

    /* 
    ====================================================
    GET COULEURS : Récupérer toutes les images d'un timbre
    ====================================================
    */

    public function getCouleurs($timbreId) {
    $sql = "SELECT c.nom
            FROM couleur c
            INNER JOIN timbre_has_couleur thc 
                ON thc.Couleur_idCouleur = c.idCouleur
            WHERE thc.timbre_idtimbre = ?";

    $stmt = $this->prepare($sql);
    $stmt->execute([$timbreId]);

    return $stmt->fetchAll();
}

    /* 
    ===================================================================================
    GET ACTIVES FILTRES : Récupérer les enchères actives selon les filtres sélectionnés
    ===================================================================================
    */

    public function getActivesFiltres($filtres = []){
        $sql = "SELECT DISTINCT
                    e.idenchere,
                    e.date_ouverture,
                    e.date_fermeture,
                    e.prix_plancher,
                    t.nom AS timbre_nom,
                    t.annee_publication,
                    t.certifie,
                    p.nom AS pays_nom,
                    tc.nom AS condition_nom,
                    i.url AS image_principale
                FROM enchere e
                INNER JOIN timbre t ON t.idtimbre = e.timbre_idtimbre
                LEFT JOIN timbre_image i ON i.timbre_idtimbre = t.idtimbre AND i.type_image = 'principale'
                LEFT JOIN pays p ON p.idPays = t.Pays_idPays
                LEFT JOIN timbre_condition tc ON tc.idTimbreCondition = t.timbre_condition_idTimbreCondition
                LEFT JOIN timbre_has_couleur thc ON thc.timbre_idtimbre = t.idtimbre
                LEFT JOIN couleur c ON c.idCouleur = thc.Couleur_idCouleur
                WHERE e.date_fermeture > NOW()";

        $params = [];

        // Pays
        if (!empty($filtres['pays'])) {
            $sql .= " AND p.nom LIKE ?";
            $params[] = "%" . $filtres['pays'] . "%";
        }

        // Année
        if (!empty($filtres['annee'])) {
            $sql .= " AND t.annee_publication = ?";
            $params[] = $filtres['annee'];
        }

        // Condition
        if (!empty($filtres['condition']) && $filtres['condition'] !== 'all') {
            $sql .= " AND tc.idTimbreCondition = ?";
            $params[] = $filtres['condition'];
        }

        // Certifié
        if ($filtres['certifie'] !== null && $filtres['certifie'] !== '') {
            $sql .= " AND t.certifie = ?";
            $params[] = $filtres['certifie'];
        }

        // Couleur
        if (!empty($filtres['couleur'])) {
            $sql .= " AND c.idCouleur = ?";
            $params[] = $filtres['couleur'];
        }

        // Prix min
        if (!empty($filtres['prix_min'])) {
            $sql .= " AND e.prix_plancher >= ?";
            $params[] = $filtres['prix_min'];
        }

        // Prix max
        if (!empty($filtres['prix_max'])) {
            $sql .= " AND e.prix_plancher <= ?";
            $params[] = $filtres['prix_max'];
        }

        $sql .= " ORDER BY e.date_fermeture ASC";

        $stmt = $this->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

     /* 
    ======================================================================================
    GET ARCHIVES FILTRES : Récupérer les enchères archivées selon les filtres sélectionnés
    ======================================================================================
    */

    public function getArchiveesFiltres($filtres = []){
        $sql = "SELECT DISTINCT
                    e.idenchere,
                    e.date_ouverture,
                    e.date_fermeture,
                    e.prix_plancher,
                    t.nom AS timbre_nom,
                    t.annee_publication,
                    t.certifie,
                    p.nom AS pays_nom,
                    tc.nom AS condition_nom,
                    i.url AS image_principale
                FROM enchere e
                INNER JOIN timbre t ON t.idtimbre = e.timbre_idtimbre
                LEFT JOIN timbre_image i ON i.timbre_idtimbre = t.idtimbre AND i.type_image = 'principale'
                LEFT JOIN pays p ON p.idPays = t.Pays_idPays
                LEFT JOIN timbre_condition tc ON tc.idTimbreCondition = t.timbre_condition_idTimbreCondition
                LEFT JOIN timbre_has_couleur thc ON thc.timbre_idtimbre = t.idtimbre
                LEFT JOIN couleur c ON c.idCouleur = thc.Couleur_idCouleur
                WHERE e.date_fermeture < NOW()";

        $params = [];

        // Pays
        if (!empty($filtres['pays'])) {
            $sql .= " AND p.nom LIKE ?";
            $params[] = "%" . $filtres['pays'] . "%";
        }

        // Année
        if (!empty($filtres['annee'])) {
            $sql .= " AND t.annee_publication = ?";
            $params[] = $filtres['annee'];
        }

        // Condition
        if (!empty($filtres['condition']) && $filtres['condition'] !== 'all') {
            $sql .= " AND tc.idTimbreCondition = ?";
            $params[] = $filtres['condition'];
        }

        // Certifié
        if ($filtres['certifie'] !== null && $filtres['certifie'] !== '') {
            $sql .= " AND t.certifie = ?";
            $params[] = $filtres['certifie'];
        }

        // Couleur
        if (!empty($filtres['couleur'])) {
            $sql .= " AND c.idCouleur = ?";
            $params[] = $filtres['couleur'];
        }

        // Prix min
        if (!empty($filtres['prix_min'])) {
            $sql .= " AND e.prix_plancher >= ?";
            $params[] = $filtres['prix_min'];
        }

        // Prix max
        if (!empty($filtres['prix_max'])) {
            $sql .= " AND e.prix_plancher <= ?";
            $params[] = $filtres['prix_max'];
        }

        $sql .= " ORDER BY e.date_fermeture DESC";

        $stmt = $this->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

}