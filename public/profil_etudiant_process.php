

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Vérification de la connexion
if (!isset($_SESSION['etudiant_id'])) {
    header('Location: login_etudiant.php');
    exit();
}

require_once __DIR__ . '/../app/models/Etudiant.php';
require_once __DIR__ . '/profil_etudiant.php';
use App\Models\Etudiant;

// Récupérer les infos de l'étudiant connecté
$etudiantModel = new Etudiant();
$etudiant = $etudiantModel->getEtudiantById($_SESSION['etudiant_id']);

// Appeler la vue du profil


var_dump($etudiant);
exit();