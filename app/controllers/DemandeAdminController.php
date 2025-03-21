<?php

namespace App\Controllers;

use App\Config\Database;
use PDO;

class DemandeAdminController {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function traiterDemande($demande_id, $action) {
        if (!$demande_id || !$action) {
            $_SESSION['error'] = "❌ Données incomplètes.";
            header('Location: demandes_admin.php');
            exit();
        }

        // ✅ Déterminer le statut
        $statut = ($action === 'accepter') ? 'acceptée' : 'refusée';

        // ✅ Mettre à jour la base
        $stmt = $this->pdo->prepare("UPDATE demandes_adhesion SET statut = :statut WHERE id = :id");
        $stmt->execute(['statut' => $statut, 'id' => $demande_id]);

        // ✅ Si accepté, ajouter l'étudiant dans la table `membres`
        if ($statut === 'acceptée') {
            $stmt = $this->pdo->prepare("SELECT etudiant_id, club_id FROM demandes_adhesion WHERE id = :id");
            $stmt->execute(['id' => $demande_id]);
            $demande = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($demande) {
                $stmt = $this->pdo->prepare("INSERT INTO membres (etudiant_id, club_id) VALUES (:etudiant_id, :club_id)");
                $stmt->execute([
                    'etudiant_id' => $demande['etudiant_id'],
                    'club_id' => $demande['club_id']
                ]);
            }
        }

        // ✅ Message de succès
        $_SESSION['message'] = "✅ La demande a bien été $statut.";
        header('Location: demandes_admin.php');
        exit();
    }
}
