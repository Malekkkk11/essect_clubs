<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use App\Models\Model; // 
require_once __DIR__ . '/Model.php'; // ✅ Inclure le modèle parent
require_once __DIR__ . '/../config/Database.php'; // ✅ Inclure la connexion à la base

class Administrateur extends Model {
    protected $table = "administrateur";

    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}











  

    

