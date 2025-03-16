<?php
session_start();
require_once __DIR__ . '/../app/config/Database.php';

$db = new \App\Config\Database();
$pdo = $db->getConnection();

// ✅ Vérifie que l'admin est connecté
if (!isset($_SESSION['admin']['id'])) {
    header('Location: login_admin.php');
    exit();
}

// ✅ Récupérer les données POST
$demande_id = $_POST['demande_id'] ?? null;
$action = $_POST['action'] ?? null;

// ✅ Vérifier que tout est bien reçu
if (!$demande_id || !$action) {
    $_SESSION['error'] = "❌ Données incomplètes.";
    header('Location: demandes_admin.php');
    exit();
}

// ✅ Déterminer le statut
$statut = ($action === 'accepter') ? 'acceptée' : 'refusée';

// ✅ Mettre à jour la base
$stmt = $pdo->prepare("UPDATE demandes_adhesion SET statut = :statut WHERE id = :id");
$stmt->execute(['statut' => $statut, 'id' => $demande_id]);

// ✅ Message de succès
$_SESSION['message'] = "✅ La demande a bien été $statut.";
header('Location: demandes_admin.php');
exit();
