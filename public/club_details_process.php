<?php



session_start();




require_once __DIR__ . '/../app/controllers/ClubDetailsController.php';

use App\Controllers\ClubDetailsController;

if (isset($_GET['id'])) {
    $controller = new ClubDetailsController();
    $controller->show($_GET['id']);
} else {
    echo "Erreur : club non trouvé.";
}
