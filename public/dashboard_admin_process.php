<?php
require_once __DIR__ . '/../app/controllers/DashboardAdminController.php';

use App\Controllers\DashboardAdminController;

// ✅ Appel du contrôleur Admin
$controller = new DashboardAdminController();
$controller->index();
