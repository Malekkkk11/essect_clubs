<?php
namespace App\Controllers;

use App\Models\Club;

require_once __DIR__ . '/../models/Club.php';

class ClubDetailsController {
    private $clubModel;

    public function __construct() {
        $this->clubModel = new Club();
    }

    public function show($club_id) {
        $club = $this->clubModel->getClubById($club_id);
        require __DIR__ . '/../../public/page_club.php'; // ✅ Charger la vue
    }
}
