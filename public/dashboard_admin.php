<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    print_r($_SESSION); 
}

$lang = $_SESSION['lang'] ?? 'fr';
// Tableau des traductions
$translations = [
    'fr' => [
        'title' => 'Tableau de Bord Admin',
        'total_requests' => 'Total Demandes',
        'accepted' => 'Demandes Acceptées',
        'rejected' => 'Demandes Refusées',
        'stats_per_club' => '📊 Statistiques par Club',
        'copyright' => '© 2025 - Tous droits réservés',
        'stats_per_club' => '📊 Statistiques par Club', 
        'pending' => 'En attente',
        'approved' => 'Acceptées',
        'denied' => 'Refusées',
    ],
    'en' => [
        'title' => 'Admin Dashboard',
        'total_requests' => 'Total Requests',
        'accepted' => 'Accepted Requests',
        'rejected' => 'Rejected Requests',
        'stats_per_club' => '📊 Statistics per Club',
        'copyright' => '© 2025 - All rights reserved',
        'stats_per_club' => '📊 Statistics per Club',
        'pending' => 'Pending',
        'approved' => 'Approved',
        'denied' => 'Denied', 
    ]
];
// Fonction pour récupérer les traductions
function t($key) {
    global $translations, $lang;
    return $translations[$lang][$key] ?? $key;
}



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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- ✅ Navbar Admin (avec compteur notifications) -->
<?php include_once __DIR__ . '/../app/views/navbar_admin.php'; ?>

<div class="container mt-5 mb-5 pb-5">
<h1 class="mb-4"><?= t('title') ?></h1>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title"><?= t('total_requests') ?></h5>
                <p class="card-text fs-3"><?= $total ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title"><?= t('accepted') ?></h5>
                <p class="card-text fs-3"><?= $acceptées ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title"><?= t('rejected') ?></h5>
                <p class="card-text fs-3"><?= $refusées ?></p>
            </div>
        </div>
    </div>
</div>
</div>

<div class="container mt-5">
<h2><?= t('stats_per_club') ?></h2>

    <div class="row">
        <?php foreach ($statsClubs as $index => $club): ?>
            <div class="col-md-6">
                <div class="card p-3">
                    <h4 class="text-center"><?= htmlspecialchars($club['nom_club']) ?></h4>
                    <canvas id="chartClub<?= $index ?>" ></canvas>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ✅ Script pour afficher les graphiques -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    <?php foreach ($statsClubs as $index => $club): ?>
        let dataClub<?= $index ?> = [
            <?= max($club['en_attente'], 0) ?>,
            <?= max($club['acceptees'], 0) ?>,
            <?= max($club['refusees'], 0) ?>
        ];

        // 🚀 Si tout est à 0, on force une valeur fictive pour éviter un graphe vide
        if (dataClub<?= $index ?>.reduce((a, b) => a + b, 0) === 0) {
            dataClub<?= $index ?> = [1, 0, 0]; // 1 en attente juste pour affichage
        }

        const ctx<?= $index ?> = document.getElementById('chartClub<?= $index ?>').getContext('2d');
        new Chart(ctx<?= $index ?>, {
            type: 'doughnut',
            data: {
                labels: ['<?= t("pending") ?>', '<?= t("approved") ?>', '<?= t("denied") ?>'],
                datasets: [{
                    data: dataClub<?= $index ?>,
                    backgroundColor: ['#ffc107', '#198754', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '50%'
            }
        });
    <?php endforeach; ?>
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<footer class="bg-light text-center py-3 mt-4">
    <div class="container d-flex justify-content-between align-items-center">
        <span><?= t('copyright') ?></span>
        <div>
            <a href="change_lang.php?lang=fr" class="btn btn-sm btn-outline-primary">🇫🇷 Français</a>
            <a href="change_lang.php?lang=en" class="btn btn-sm btn-outline-secondary">🇬🇧 English</a>
        </div>
    </div>
</footer>

</body>
</html>
