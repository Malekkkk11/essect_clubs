<?php
// Démarrer la session
session_start();

// Charger les configurations et les fichiers essentiels
require_once 'app/config/Database.php';

// Définir le contrôleur par défaut
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Construire le chemin du contrôleur
$controllerFile = "app/controllers/" . ucfirst($controller) . "Controller.php";

// Vérifier si le contrôleur existe
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = ucfirst($controller) . "Controller";

    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass();

        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
        } else {
            die("Méthode '$action' introuvable dans le contrôleur '$controllerClass'.");
        }
    } else {
        die("Classe '$controllerClass' introuvable.");
    }
} else {
    die("Contrôleur '$controller' introuvable.");
}
// Exemple de gestion des routes
if ($_SERVER['REQUEST_URI'] === '/login_etudiant.php' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new \App\Controllers\LoginEtudiantController();
    $controller->login();
} elseif ($_SERVER['REQUEST_URI'] === '/login_admin.php' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new \App\Controllers\LoginAdminController();
    $controller->login();
}
