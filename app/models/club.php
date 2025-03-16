<?php
namespace App\Models;

use App\Config\Database;
use PDO;

require_once __DIR__ . '/../config/Database.php';

class Club {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // ✅ Tous les clubs
    public function getAllClubs() {
        $stmt = $this->pdo->query("SELECT * FROM clubs");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   

    // ✅ Clubs où l'étudiant est membre
    public function getMesClubs($etudiant_id) {
        $stmt = $this->pdo->prepare("
            SELECT c.* FROM clubs c
            JOIN membres m ON c.id = m.club_id
            WHERE m.etudiant_id = :etudiant_id
        ");
        $stmt->execute(['etudiant_id' => $etudiant_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Demandes d'adhésion
    public function getMesDemandes($etudiant_id) {
        $stmt = $this->pdo->prepare("
            SELECT da.*, c.nom AS nom_club 
            FROM demandes_adhesion da
            JOIN clubs c ON da.club_id = c.id
            WHERE da.etudiant_id = :etudiant_id
        ");
        $stmt->execute(['etudiant_id' => $etudiant_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getClubById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM clubs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
