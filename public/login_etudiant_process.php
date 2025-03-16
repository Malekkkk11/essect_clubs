<?php
session_start();

require_once '../app/models/Etudiant.php';
$etudiantModel = new \App\Models\Etudiant();

// ⚙️ Données venant du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// 🔍 Récupérer étudiant
$etudiant = $etudiantModel->getByEmail($email);

if ($etudiant && $etudiant['mot_de_passe'] == $password) { // ⚠️ Remplace par password_verify() si hashé

    // ✅ Stocker un tableau complet "etudiant" dans la session
    $_SESSION['etudiant'] = [
        'id' => $etudiant['id'],
        'prenom' => $etudiant['prenom'],
        'email' => $etudiant['email']
    ];

    // ✅ Rediriger vers dashboard
    header('Location: dashboard_etudiant_process.php');
    exit();
} else {
    // ❌ Mauvais identifiants
    header('Location: login_etudiant.php?error=1');
    exit();
}
