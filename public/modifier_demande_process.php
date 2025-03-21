<?php
session_start();
require_once __DIR__ . '/../app/config/Database.php';

if (!isset($_SESSION['etudiant']['id'])) {
    header('Location: login_etudiant.php');
    exit();
}

$etudiant_id = $_SESSION['etudiant']['id'];
$demande_id = $_POST['demande_id'] ?? null;
$motivation = trim($_POST['motivation'] ?? '');

if (!$demande_id || empty($motivation)) {
    header("Location: dashboard_etudiant_process.php?message=invalid");
    exit();
}

$db = new \App\Config\Database();
$pdo = $db->getConnection();

// ✅ Vérifie que la demande existe et appartient à l'étudiant
$stmt = $pdo->prepare("SELECT * FROM demandes_adhesion WHERE id = :id AND etudiant_id = :etudiant_id AND statut = 'en attente'");
$stmt->execute([
    'id' => $demande_id,
    'etudiant_id' => $etudiant_id
]);
$demande = $stmt->fetch();

if (!$demande) {
    die("❌ Demande introuvable ou non modifiable.");
}

// ✅ Traitement du CV si un nouveau est fourni
$newFileName = $demande['cv']; // garde l'ancien nom par défaut
if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['cv']['tmp_name'];
    $fileName = $_FILES['cv']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if ($fileExtension !== 'pdf') {
        header("Location: dashboard_etudiant_process.php?message=cv_type_error");
        exit();
    }

    $newFileName = "cv_" . $etudiant_id . "_" . time() . ".pdf";
    $uploadDir = __DIR__ . '/../uploads/cv/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $destPath = $uploadDir . $newFileName;
    if (!move_uploaded_file($fileTmpPath, $destPath)) {
        header("Location: dashboard_etudiant_process.php?message=cv_upload_error");
        exit();
    }

    // Met à jour le chemin relatif
    $newFileName = 'uploads/cv/' . $newFileName;
}

// ✅ Mise à jour dans la base de données
$stmt = $pdo->prepare("UPDATE demandes_adhesion SET message = :message, cv = :cv WHERE id = :id");
$stmt->execute([
    'message' => $motivation,
    'cv' => $newFileName,
    'id' => $demande_id
]);

header("Location: dashboard_etudiant_process.php?message=modification_ok");
exit();
