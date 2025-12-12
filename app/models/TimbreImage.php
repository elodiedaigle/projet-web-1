<?php
namespace App\Models;

class TimbreImage extends CRUD {
    protected $table = 'timbre_image';
    protected $primaryKey = 'idtimbre_image';
    protected $fillable = [
        'url',
        'type_image',
        'timbre_idtimbre'
    ];

    /*
    ======================================================
    GET IMAGE : Récupérer les images associées à un timbre
    ======================================================
    */

    public function getImages($timbreId)
    {
        $sql = "SELECT url, type_image FROM timbre_image WHERE timbre_idtimbre = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$timbreId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
