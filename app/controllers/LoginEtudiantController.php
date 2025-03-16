<?php
namespace App\Controllers;

use App\Models\Etudiant;  // Assure-toi que tu importes la classe correctement

class LoginEtudiantController {
    public function login($email, $password) {
        $etudiantModel = new Etudiant();
        $etudiant = $etudiantModel->getByEmail($email);

        if ($etudiant && $password == $etudiant['mot_de_passe']) {
            // La connexion est réussie, démarrer la session
            session_start();
            $_SESSION['etudiant_id'] = $etudiant['id'];
            header('Location: dashboard_etudiant_process.php');
            exit();
        } else {
            // Connexion échouée
            echo "Email ou mot de passe incorrect.";
        }
    }
}
