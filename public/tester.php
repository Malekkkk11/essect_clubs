<?php
require_once '../app/models/Etudiant.php';
require_once '../app/models/Club.php';
require_once '../app/models/DemandeAdhesion.php';
require_once '../app/models/Administrateur.php';

use App\Models\Etudiant;
use App\Models\Club;
use App\Models\DemandeAdhesion;
use App\Models\Administrateur;

$etudiantModel = new Etudiant();
print_r($etudiantModel->getAllEtudiants());

$clubModel = new Club();
print_r($clubModel->getAllClubs());

$adminModel = new Administrateur();
print_r($adminModel->getAllAdmins());
