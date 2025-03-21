<?php
session_start();
require_once __DIR__ . '/../app/config/Database.php';

// ✅ Vérifier que l'admin est connecté
if (!isset($_SESSION['admin']['id'])) {
    header('Location: login_admin.php');
    exit();
}

$db = new \App\Config\Database();
$pdo = $db->getConnection();

// ✅ Récupérer toutes les demandes
$stmt = $pdo->query("
    SELECT d.*, e.nom AS nom_etudiant, e.prenom, c.nom AS nom_club
    FROM demandes_adhesion d
    JOIN etudiants e ON d.etudiant_id = e.id
    JOIN clubs c ON d.club_id = c.id
    ORDER BY d.date_demande DESC
");
$demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des demandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 80px; }
        .badge-en-attente { background-color: #ffc107; }
        .badge-acceptee { background-color: #28a745; }
        .badge-refusee { background-color: #dc3545; }
        .card { box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<?php include_once __DIR__ . '/../app/views/navbar_admin.php'; ?>
<?php include_once __DIR__ . '/../app/views/alert_admin.php'; ?>

<div class="container mt-5 pt-5">
    <h1 class="mb-4">📋 Gestion des demandes d'adhésion</h1>

    <?php if (empty($demandes)): ?>
        <div class="alert alert-info text-center">Aucune demande d'adhésion pour le moment.</div>
    <?php else: ?>
        <?php foreach ($demandes as $demande): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= htmlspecialchars($demande['prenom'] . ' ' . $demande['nom_etudiant']) ?> souhaite rejoindre 
                        <strong><?= htmlspecialchars($demande['nom_club']) ?></strong>
                    </h5>

                    <p><strong>Message :</strong> <?= nl2br(htmlspecialchars($demande['message'])) ?></p>

                    <p><strong>CV :</strong> <a href="/clubs_essect/<?= htmlspecialchars($demande['cv']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">📄 Voir le CV</a></p>

                    <p><strong>Statut :</strong>
                        <span class="badge 
                            <?= $demande['statut'] == 'en attente' ? 'badge-en-attente' : ($demande['statut'] == 'acceptée' ? 'badge-acceptee' : 'badge-refusee') ?>">
                            <?= ucfirst($demande['statut']) ?>
                        </span>
                    </p>

                    <?php if ($demande['statut'] == 'en attente'): ?>
                        <form action="traitement_demande.php" method="POST" class="d-inline">
    <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">
    <button type="submit" name="action" value="accepter" class="btn btn-success btn-sm">✅ Accepter</button>
</form>

<form action="traitement_demande.php" method="POST" class="d-inline">
    <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">
    <button type="submit" name="action" value="refuser" class="btn btn-danger btn-sm">❌ Refuser</button>
</form>

                    <?php else: ?>
                        <p><em>Déjà traité.</em></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
