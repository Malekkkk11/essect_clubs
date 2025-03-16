<?php

namespace App\Models;

use App\Config\Database;

require_once __DIR__ . '/../config/Database.php';

class Model {
    protected $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }
}
