<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Etudiant;

$etudiantModel = new Etudiant();
$etudiant = $etudiantModel->getEtudiantById(1); // Remplace par un ID existant

if ($etudiant) {
    echo "Étudiant trouvé : " . $etudiant['nom'] . " " . $etudiant['prenom'];
} else {
    echo "Aucun étudiant trouvé.";
}
