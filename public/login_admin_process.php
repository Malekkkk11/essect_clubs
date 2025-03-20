<?php

ob_start(); // ✅ Évite les erreurs d'affichage avant redirection
session_start();
require_once '../app/controllers/LoginAdminController.php';

use App\Controllers\LoginAdminController;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "✅ login_admin_process.php bien exécuté !<br>";

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    echo "Email envoyé : $email<br>";
    echo "Mot de passe envoyé : $password<br>";

    $controller = new LoginAdminController();
    $controller->login($email, $password);
}
exit();
?>
