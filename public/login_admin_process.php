<?php
session_start();
require_once '../app/models/Administrateur.php';

$adminModel = new \App\Models\Administrateur();

$email = $_POST['email'];
$password = $_POST['password'];

// ✅ Récupérer l'admin depuis la base
$admin = $adminModel->getByEmail($email);

// ✅ Vérifier mot de passe
if ($admin && $admin['mot_de_passe'] === $password) { // ⚠️ Remplace par password_verify si c'est hashé !

    // ✅ Stocker l'admin connecté dans la session
    $_SESSION['admin'] = [
        'id' => $admin['id'],
        'email' => $admin['email']
    ];

    // ✅ Rediriger vers le dashboard
    header('Location: dashboard_admin_process.php');
    exit();

} else {
    // ❌ Si erreur, message et retour
    $_SESSION['error'] = "❌ Email ou mot de passe incorrect.";
    header('Location: login_admin.php');
    exit();
}
