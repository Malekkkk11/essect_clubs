<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Etudiant;

var_dump(class_exists('App\Models\Etudiant')); // Doit afficher bool(true)
