<?php
session_start();
require_once '../app/models/Etudiant.php';

// Vérifier la session
if (!isset($_SESSION['etudiant']['id'])) {
    header('Location: login_etudiant.php');
    exit();
}

$etudiantModel = new \App\Models\Etudiant();
$etudiant = $etudiantModel->getEtudiantById($_SESSION['etudiant']['id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { padding-top: 80px; } </style>
</head>
<body>

<?php
// ✅ On suppose que la session a déjà été démarrée AVANT ce fichier
$prenom = htmlspecialchars($_SESSION['etudiant']['prenom'] ?? 'Etudiant');
?>

<?php include_once '../app/views/navbar_etudiant.php'; ?>

<?php include_once '../app/views/alert_etudiant.php'; ?> <!-- ✅ Alert étudiant si tu veux -->

<div class="container mt-5">
    <h1>Bienvenue, <?= htmlspecialchars($etudiant['prenom']) ?> !</h1>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
