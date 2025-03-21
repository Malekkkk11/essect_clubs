<?php
namespace App\Controllers;

use App\Models\Etudiant;  // Assure-toi que tu importes la classe correctement

class LoginEtudiantController {
    public function login($email, $password) {
        $etudiantModel = new Etudiant();
        $etudiant = $etudiantModel->getByEmail($email);

        if ($etudiant && $password == $etudiant['mot_de_passe']) {
            session_start();
            session_regenerate_id(true); // 🔥 Sécurise la session
            
            session_start();
            $_SESSION['etudiant_id'] = $etudiant['id'];
            $_SESSION['etudiant'] = [
                'id' => $etudiant['id'],
                'prenom' => $etudiant['prenom'],
                'email' => $etudiant['email']
            ];
            
            echo "✅ Avant redirection :";
print_r($_SESSION);
exit();

header('Location: dashboard_etudiant_process.php');
exit();
            
            
        } else {
            echo "❌ Email ou mot de passe incorrect.";
        }
        
    }
}
