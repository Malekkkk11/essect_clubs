<?php

require_once __DIR__ . '/../app/config/Database.php';

session_start();
$db = new \App\Config\Database();
$pdo = $db->getConnection();

// ✅ Vérifie que l'étudiant est connecté
if (!isset($_SESSION['etudiant']['id'])) {
    header('Location: login_etudiant.php');
    exit();
}

$etudiant_id = $_SESSION['etudiant']['id'];
$club_id = $_POST['club_id'] ?? null;
$motivation = trim($_POST['motivation'] ?? '');

if (!$club_id || empty($motivation)) {
    header('Location: dashboard_etudiant_process.php?message=invalid');
    exit();
}

// ✅ Vérifie si une demande existe déjà
$stmt = $pdo->prepare("SELECT * FROM demandes_adhesion WHERE etudiant_id = :etudiant_id AND club_id = :club_id");
$stmt->execute(['etudiant_id' => $etudiant_id, 'club_id' => $club_id]);
$existingRequest = $stmt->fetch();

if ($existingRequest) {
    header("Location: club_details_process.php?id=$club_id&message=exist");
    exit();
}

// ✅ Gestion du CV
if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['cv']['tmp_name'];
    $fileName = $_FILES['cv']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // ✅ Vérifie que c'est bien un PDF
    if ($fileExtension !== 'pdf') {
        header("Location: club_details_process.php?id=$club_id&message=cv_type_error");
        exit();
    }

    // ✅ Renommer et stocker le fichier
    $newFileName = "cv_" . $etudiant_id . "_" . time() . ".pdf";
    $uploadDir = __DIR__ . '/../uploads/cv/';
    $dest_path = $uploadDir . $newFileName;

    // ✅ Créer le dossier si nécessaire
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        // ✅ Insertion de la demande
        $stmt = $pdo->prepare("
            INSERT INTO demandes_adhesion (etudiant_id, club_id, cv, statut, date_demande, message)
            VALUES (:etudiant_id, :club_id, :cv, 'en attente', NOW(), :message)
        ");
        $stmt->execute([
            'etudiant_id' => $etudiant_id,
            'club_id' => $club_id,
            'cv' => 'uploads/cv/' . $newFileName,
            'message' => $motivation
        ]);

        // ✅ Redirection avec succès
        header("Location: club_details_process.php?id=$club_id&message=success");
        exit();
    } else {
        header("Location: club_details_process.php?id=$club_id&message=cv_upload_error");
        exit();
    }
} else {
    header("Location: club_details_process.php?id=$club_id&message=cv_upload_error");
    exit();
}
