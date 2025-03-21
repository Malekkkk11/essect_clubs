<?php
require_once '../app/config/Database.php';
session_start();

$db = new \App\Config\Database();
$pdo = $db->getConnection();

$demande_id = $_GET['id'] ?? null;
$etudiant_id = $_SESSION['etudiant']['id'] ?? null;

// Vérifie que la demande est bien à lui et en attente
$stmt = $pdo->prepare("SELECT * FROM demandes_adhesion WHERE id = :id AND etudiant_id = :etudiant_id AND statut = 'en attente'");
$stmt->execute(['id' => $demande_id, 'etudiant_id' => $etudiant_id]);
$demande = $stmt->fetch();

if ($demande) {
    $stmt = $pdo->prepare("DELETE FROM demandes_adhesion WHERE id = :id");
    $stmt->execute(['id' => $demande_id]);
    header("Location: dashboard_etudiant_process.php?message=suppression_ok");
    exit();
} else {
    header("Location: dashboard_etudiant_process.php?message=not_allowed");
    exit();
}
?>