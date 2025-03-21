<?php
session_start();
require_once '../app/config/Database.php';
require_once '../app/controllers/DemandeAdminController.php';

use App\Controllers\DemandeAdminController;

// ✅ Vérifie que l'admin est connecté
if (!isset($_SESSION['admin']['id'])) {
    header('Location: login_admin.php');
    exit();
}

// ✅ Récupérer les données POST
$demande_id = $_POST['demande_id'] ?? null;
$action = $_POST['action'] ?? null;

// ✅ Création du contrôleur et appel de la méthode
$controller = new DemandeAdminController();
$controller->traiterDemande($demande_id, $action);
