<?php
session_start();

if (!isset($_SESSION['etudiant_id'])) {
    header('Location: login_etudiant.php');
    exit();
}

require_once __DIR__ . '/../app/controllers/DashboardEtudiantController.php';
include_once '../app/views/navbar_etudiant.php';
use App\Controllers\DashboardEtudiantController;

// Appel du contrôleur
$controller = new DashboardEtudiantController();
$controller->index($_SESSION['etudiant_id']);
