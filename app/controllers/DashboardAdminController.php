<?php
namespace App\Controllers;

require_once __DIR__ . '/../config/Database.php';

use App\Config\Database;
use PDO;

class DashboardAdminController {

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['admin']['id'])) {
            header('Location: login_admin.php');
            exit();
        }
    
        // ✅ Requête SANS filtre de mois/année
        $stmt = $this->pdo->prepare("
            SELECT 
                c.nom AS nom_club,
                IFNULL(SUM(CASE WHEN d.statut = 'en attente' THEN 1 ELSE 0 END), 0) AS en_attente,
                IFNULL(SUM(CASE WHEN d.statut = 'acceptée' THEN 1 ELSE 0 END), 0) AS acceptees,
                IFNULL(SUM(CASE WHEN d.statut = 'refusée' THEN 1 ELSE 0 END), 0) AS refusees
            FROM 
                clubs c
            LEFT JOIN 
                demandes_adhesion d ON c.id = d.club_id
            GROUP BY 
                c.nom
            ORDER BY 
                c.nom;
        ");
        $stmt->execute();
        $statsClubs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

  
        // ✅ Rendre les stats accessibles à la vue
        extract(['statsClubs' => $statsClubs]);
        require_once __DIR__ . '/../../public/dashboard_admin.php';
    }
    
}
