<?php
require_once '../app/models/Etudiant.php';


// Vérifier la session
if (!isset($_SESSION['etudiant']['id'])) {
    header('Location: login_etudiant.php');
    exit();
}
$lang = $_GET['lang'] ?? 'fr';

$etudiantModel = new \App\Models\Etudiant();
$etudiant = $etudiantModel->getEtudiantById($_SESSION['etudiant']['id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { padding-top: 80px; } </style>

    <meta charset="UTF-8">
    <title>Dashboard Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            padding-bottom: 80px; 
        }
        .sidebar {
            height: 100vh;
            background: #343a40;
            color: white;
            padding: 20px 10px;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
        }
        .sidebar a {
            color: white;
            padding: 12px 15px;
            display: block;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #495057;
        }
        .content {
            margin-left: 270px;
            padding: 30px;
        }
        .profile-pic {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
</head>
<body>

<?php
// ✅ On suppose que la session a déjà été démarrée AVANT ce fichier
$prenom = htmlspecialchars($_SESSION['etudiant']['prenom'] ?? 'Etudiant');
?>

<?php include_once __DIR__ . '/../app/views/navbar_etudiant.php';?>

<?php include_once '../app/views/alert_etudiant.php'; ?> <!-- ✅ Alert étudiant si tu veux -->


<!-- ✅ Sidebar -->
<div class="sidebar pt-5">
    <h4 class="text-center mb-4">Menu</h4>
    <a href="#clubs-disponibles" class="active">📜 Les Clubs</a>
    <a href="#mes-clubs">👥 Mes Clubs</a>
    <a href="#mes-demandes">📝 Mes Demandes</a>
</div>
<?php require_once __DIR__ . '/../app/config/lang.php'; 

?>
<!-- ✅ Contenu Principal -->
<div class="content pt-5">

    <!-- Les Clubs -->
    <h3 id="clubs-disponibles" class="fw-bold mb-4">📜 Clubs Disponibles</h3>
    <div class="row">
        <?php foreach ($clubs as $club): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if (!empty($club['logo'])): ?>
                        <img src="/clubs_essect/<?= htmlspecialchars($club['logo']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x200" class="card-img-top">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($club['nom']) ?> (<?= htmlspecialchars($club['categorie']) ?>)</h5>
                        <p class="card-text"><?= htmlspecialchars($club['description']) ?></p>
                        <a href="club_details_process.php?id=<?= $club['id'] ?>" class="btn btn-outline-primary mt-auto">Voir le Club</a>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Mes Clubs -->
    <h3 id="mes-clubs" class="fw-bold mt-5 mb-4">👥 <?= t('my_requests') ?></h3>
    <ul class="list-group mb-4">
        <?php foreach ($mesClubs as $club): ?>
            <li class="list-group-item"><?= htmlspecialchars($club['nom']) ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- Mes Demandes -->
    <h3 id="mes-demandes" class="fw-bold mt-5 mb-4">📝 Mes Demandes d'Adhésion</h3>
    <ul class="list-group">
    <?php foreach ($mesDemandes as $demande): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            Club : <?= htmlspecialchars($demande['nom_club']) ?> - 
            Statut : <strong><?= htmlspecialchars($demande['statut']) ?></strong>
        </div>
        <?php if ($demande['statut'] === 'en attente'): ?>
            <div>
            <button class="btn btn-sm btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#modifierDemandeModal<?= $demande['id'] ?>">✏️ Modifier</button>
                <a href="supprimer_demande.php?id=<?= $demande['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')">🗑️ Supprimer</a>
            </div>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
    </ul>
    <?php foreach ($mesDemandes as $demande): ?>
<?php if ($demande['statut'] === 'en attente'): ?>
<!-- Modal pour modifier la demande -->
<div class="modal fade" id="modifierDemandeModal<?= $demande['id'] ?>" tabindex="-1" aria-labelledby="modifierDemandeLabel<?= $demande['id'] ?>" aria-hidden="true">
  <div class="modal-dialog">
    <form action="modifier_demande_process.php" method="POST" enctype="multipart/form-data" class="modal-content">
        <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">

        <div class="modal-header">
            <h5 class="modal-title" id="modifierDemandeLabel<?= $demande['id'] ?>">✏️ Modifier ma demande</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>

        <div class="modal-body">
            <div class="mb-3">
                <label for="motivation<?= $demande['id'] ?>" class="form-label">Message de motivation</label>
                <textarea class="form-control" name="motivation" id="motivation<?= $demande['id'] ?>" rows="3" required><?= htmlspecialchars($demande['message']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="cv<?= $demande['id'] ?>" class="form-label">Changer le CV (PDF uniquement)</label>
                <input type="file" class="form-control" name="cv" id="cv<?= $demande['id'] ?>">
                <small class="text-muted">Laisser vide si vous ne souhaitez pas changer le CV.</small>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
        </div>
    </form>
  </div>
</div>
<?php endif; ?>
<?php endforeach; ?>
<?php if (isset($_GET['message']) && $_GET['message'] === 'modification_ok'): ?>
    <div class="alert alert-success text-center">
        ✅ Demande modifiée avec succès.
    </div>
<?php endif; ?>

</div>

<footer class="bg-light text-center py-3 mt-4 fixed-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <span><?= t('copyright') ?></span>
        <div>
            <a href="change_lang.php?lang=fr" class="btn btn-sm btn-outline-primary">🇫🇷</a>
            <a href="change_lang.php?lang=en" class="btn btn-sm btn-outline-secondary">🇬🇧</a>
        </div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
