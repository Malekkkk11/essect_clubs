<?php
session_start();
require_once 'C:\xampp\htdocs\clubs_essect\app\controllers\loginController.php';


use App\Controllers\loginController;

$auth = new loginController();
$auth->logout();
header("Location: login_etudiant.php");
exit();
