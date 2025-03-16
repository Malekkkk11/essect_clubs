<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../app/config/Database.php';

// ✅ Vérification admin connecté
if (!isset($_SESSION['admin']['id'])) {
    header('Location: login_admin.php');
    exit();
}

// ✅ Connexion à la base
$db = new \App\Config\Database();
$pdo = $db->getConnection();

// ✅ Stats
$total = $pdo->query("SELECT COUNT(*) as nb FROM demandes_adhesion")->fetch();
$total = $total ? intval($total['nb']) : 0;

$acceptées = $pdo->query("SELECT COUNT(*) as nb FROM demandes_adhesion WHERE statut = 'acceptée'")->fetch();
$acceptées = $acceptées ? intval($acceptées['nb']) : 0;

$refusées = $pdo->query("SELECT COUNT(*) as nb FROM demandes_adhesion WHERE statut = 'refusée'")->fetch();
$refusées = $refusées ? intval($refusées['nb']) : 0;

// ✅ Demandes en attente pour la clochette
$demandes_attente = $pdo->query("SELECT COUNT(*) as nb FROM demandes_adhesion WHERE statut = 'en attente'")->fetch();
$demandes_attente = $demandes_attente ? intval($demandes_attente['nb']) : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 80px; }
        .card { box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<!-- ✅ Navbar Admin (avec compteur notifications) -->
<?php include_once __DIR__ . '/../app/views/navbar_admin.php'; ?>

<div class="container mt-5 pt-5">
    <h1 class="mb-4">📊 Tableau de bord</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Demandes</h5>
                    <p class="card-text fs-3"><?= $total ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Demandes Acceptées</h5>
                    <p class="card-text fs-3"><?= $acceptées ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Demandes Refusées</h5>
                    <p class="card-text fs-3"><?= $refusées ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
<h2>📊 Statistiques globales par Club</h2>

<div class="container">
    <?php foreach ($statsClubs as $index => $club): ?>
        <div class="my-5">
            <h4><?= htmlspecialchars($club['nom_club']) ?></h4>
            <canvas id="chartClub<?= $index ?>" width="200" height="200"></canvas>
        </div>

        <script>
            const ctx<?= $index ?> = document.getElementById('chartClub<?= $index ?>').getContext('2d');
            new Chart(ctx<?= $index ?>, {
                type: 'doughnut',
                data: {
                    labels: ['En attente', 'Acceptées', 'Refusées'],
                    datasets: [{
                        data: [<?= $club['en_attente'] ?>, <?= $club['acceptees'] ?>, <?= $club['refusees'] ?>],
                        backgroundColor: ['#ffc107', '#198754', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        </script>
    <?php endforeach; ?>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
