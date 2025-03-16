<?php
namespace App\controllers;

use App\Models\Etudiant;
use App\Models\Administrateur;

require_once __DIR__ . '/../models/Etudiant.php';
require_once __DIR__ . '/../models/Administrateur.php';

class LoginController {

    
    public function login($email, $password, $role) {
        if ($role === "etudiant") {
            $userModel = new Etudiant();
        } elseif ($role === "admin") {
            $userModel = new Administrateur();
        } else {
            return "Rôle invalide.";
        }

        $user = $userModel->getByEmail($email);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $role;
            return "Connexion réussie.";
        } else {
            return "Email ou mot de passe incorrect.";
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        return "Déconnexion réussie.";
    }
}
