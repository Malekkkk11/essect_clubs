<?php

namespace App\Models;
require_once __DIR__ . '/Model.php'; 

use PDO;
use App\Config\Database;

require_once __DIR__ . '/../config/Database.php';

class Etudiant extends Model {
    protected $table = "etudiants";

    // ✅ Ajouter le constructeur pour hériter de la connexion PDO
    public function __construct() {
        parent::__construct(); // Important pour que $this->pdo soit accessible
    }

    // 🔍 Récupérer tous les étudiants
    public function getAllEtudiants() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔍 Récupérer un étudiant par son ID
    public function getEtudiantById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔍 Récupérer un étudiant par son email
    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Correction du createEtudiant : ajouter les bonnes colonnes
    public function createEtudiant($nom, $prenom, $email, $mot_de_passe, $class, $photo, $telephone, $adresse) {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} (nom, prenom, email, mot_de_passe, class, photo, telephone, adresse) 
            VALUES (:nom, :prenom, :email, :mot_de_passe, :class, :photo, :telephone, :adresse)
        ");
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'mot_de_passe' => password_hash($mot_de_passe, PASSWORD_DEFAULT),
            'class' => $class,
            'photo' => $photo,
            'telephone' => $telephone,
            'adresse' => $adresse
        ]);
    }

    // ✅ Mise à jour de la photo de profil
    public function updatePhoto($id, $photo) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET photo = :photo WHERE id = :id");
        return $stmt->execute(['photo' => $photo, 'id' => $id]);
    }
}
