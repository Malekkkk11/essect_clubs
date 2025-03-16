<?php
namespace App\Controllers;

use App\Models\Club;
use App\Models\Etudiant;

require_once __DIR__ . '/../models/Club.php';
require_once __DIR__ . '/../models/Etudiant.php';

class DashboardEtudiantController {
    private $clubModel;
    private $etudiantModel;

    public function __construct() {
        $this->clubModel = new Club();
        $this->etudiantModel = new Etudiant();
    }

    public function index($etudiant_id) {
        $clubs = $this->clubModel->getAllClubs();
        $mesClubs = $this->clubModel->getMesClubs($etudiant_id);
        $mesDemandes = $this->clubModel->getMesDemandes($etudiant_id);
        $etudiant = $this->etudiantModel->getEtudiantById($etudiant_id);

        // Passer les variables à la vue
        require __DIR__ . '/../../public/dashboard_etudiant.php';
    }
}
