<?php
if (!isset($_SESSION)) {
    session_start();
}




if (!isset($_SESSION['etudiant']['id'])) {
    die("❌ Erreur : Aucun étudiant connecté !");
}

require_once __DIR__ . '/../app/controllers/DashboardEtudiantController.php';

use App\Controllers\DashboardEtudiantController;

// Appel du contrôleur
$controller = new DashboardEtudiantController();
$controller->index($_SESSION['etudiant']['id']);
