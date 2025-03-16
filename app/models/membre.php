<?php
namespace App\Models;

use App\Config\Database;
use PDO;

require_once __DIR__ . '/../config/Database.php';

class Membre {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // ✅ Ajouter un étudiant comme membre d'un club
    public function ajouterMembre($etudiant_id, $club_id) {
        $stmt = $this->pdo->prepare("
            INSERT INTO membres (etudiant_id, club_id) 
            VALUES (:etudiant_id, :club_id)
        ");
        return $stmt->execute([
            'etudiant_id' => $etudiant_id,
            'club_id' => $club_id
        ]);
    }

    // ✅ Vérifier si un étudiant est déjà membre d'un club
    public function estMembre($etudiant_id, $club_id) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM membres 
            WHERE etudiant_id = :etudiant_id AND club_id = :club_id
        ");
        $stmt->execute([
            'etudiant_id' => $etudiant_id,
            'club_id' => $club_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Récupérer tous les clubs où un étudiant est membre
    public function getMesClubs($etudiant_id) {
        $stmt = $this->pdo->prepare("
            SELECT c.* FROM clubs c
            JOIN membres m ON c.id = m.club_id
            WHERE m.etudiant_id = :etudiant_id
        ");
        $stmt->execute(['etudiant_id' => $etudiant_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Retirer un étudiant d'un club (optionnel si tu veux supprimer l'adhésion)
    public function retirerMembre($etudiant_id, $club_id) {
        $stmt = $this->pdo->prepare("
            DELETE FROM membres
            WHERE etudiant_id = :etudiant_id AND club_id = :club_id
        ");
        return $stmt->execute([
            'etudiant_id' => $etudiant_id,
            'club_id' => $club_id
        ]);
    }
}
