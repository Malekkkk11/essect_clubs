<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/../app/config/Database.php';

$db = new \App\Config\Database();
$pdo = $db->getConnection();

// ✅ Génération des statistiques
$stmt = $pdo->prepare("
    SELECT 
        c.nom AS nom_club,
        IFNULL(SUM(CASE WHEN d.statut = 'en attente' THEN 1 ELSE 0 END), 0) AS en_attente,
        IFNULL(SUM(CASE WHEN d.statut = 'acceptée' THEN 1 ELSE 0 END), 0) AS acceptees,
        IFNULL(SUM(CASE WHEN d.statut = 'refusée' THEN 1 ELSE 0 END), 0) AS refusees
    FROM clubs c
    LEFT JOIN demandes_adhesion d ON c.id = d.club_id
    GROUP BY c.nom
    ORDER BY c.nom;
");
$stmt->execute();
$statsClubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Vérification avant inclusion
if (empty($statsClubs)) {
    die("❌ Aucune statistique trouvée !");
}





require_once 'dashboard_admin.php';
exit();

use App\Controllers\DashboardAdminController;

// ✅ Appel du contrôleur Admin
$controller = new DashboardAdminController();
$controller->index();

