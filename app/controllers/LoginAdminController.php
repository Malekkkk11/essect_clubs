<?php
namespace App\Controllers;

use App\Models\Administrateur;
ob_start(); // ✅ Évite tout affichage avant header()
session_start();
require_once __DIR__ . '/../models/Administrateur.php';
echo "✅ LoginAdminController est bien appelé !<br>";
class LoginAdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Administrateur();
    }

    public function login($email, $password) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $admin = $this->adminModel->getByEmail(trim($email));
    
     
    
        if ($admin && trim($admin['mot_de_passe']) === trim($password)) {
            $_SESSION['admin'] = [
                'id' => $admin['id'],
                'email' => $admin['email']
            ];
            echo "✅ Connexion réussie, session enregistrée !<br>";
            print_r($_SESSION);
            header('Location: dashboard_admin_process.php');
            exit();
          
        } else {
            echo "❌ La connexion a échoué. Redirection...<br>";
            $_SESSION['error'] = "❌ Email ou mot de passe incorrect.";
            header('Location: login_admin.php');
            exit();
        }
    }
    
}
