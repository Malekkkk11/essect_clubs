<?php
namespace App\Models;

use App\Config\Database;
use PDO;

require_once __DIR__ . '/../config/Database.php';

class DemandeAdhesion extends Model {
    protected $table = "demandes_adhesion";

    public function getAllDemandes() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function getDemandeById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function createDemande($etudiant_id, $club_id, $cv) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (etudiant_id, club_id, cv) VALUES (:etudiant_id, :club_id, :cv)");
        return $stmt->execute([
            'etudiant_id' => $etudiant_id,
            'club_id' => $club_id,
            'cv' => $cv
        ]);
    }

    public function updateStatut($id, $statut) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET statut = :statut WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'statut' => $statut
        ]);
    }
}
