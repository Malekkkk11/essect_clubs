<?php
session_start();

// Vérifier si une langue est sélectionnée
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Rediriger vers la page précédente
$previousPage = $_SERVER['HTTP_REFERER'] ?? 'dashboard_admin_process.php';
header('Location: ' . $previousPage);
exit();
