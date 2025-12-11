<?php
namespace App\Models;

class TimbrePays extends CRUD {
    protected $table = 'pays';
    protected $primaryKey = 'idPays';
    protected $fillable = ['nom'];

    public function findByNom($nom) {
        $sql = "SELECT * FROM $this->table WHERE nom = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$nom]);
        return $stmt->fetch();
    }
}