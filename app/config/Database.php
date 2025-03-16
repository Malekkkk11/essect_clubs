<?php
namespace App\Config; // ✅ Ajout du namespace

use PDO;
use PDOException; // ✅ Importation de PDOException pour éviter les erreurs

class Database {
    private $host = "localhost";
    private $dbname = "clubs_essect";
    private $username = "root";
    private $pwd = "";
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->pwd,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active les erreurs
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Mode de récupération par défaut
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
