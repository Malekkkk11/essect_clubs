<?php
namespace App\Controllers;

use App\Models\Administrateur; // ✅ Import du modèle Administrateur

require_once __DIR__ . '/../models/Administrateur.php'; // ✅ Inclusion du fichier modèle

class LoginAdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Administrateur();
    }

    public function login($email, $password) {
        $admin = $this->adminModel->getByEmail($email);

        if ($admin && $admin['mot_de_passe'] === $password) {
            session_start();
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: dashboard_admin_process.php');
            exit();
        } else {
            echo "Email ou mot de passe incorrect.";
        }
    }
}
