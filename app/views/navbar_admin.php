<?php
// ✅ On récupère le nombre de demandes en attente depuis la session ou variable transmise
$demandes_attente = $demandes_attente ?? 0;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard_admin.php">Espace Admin</a>

        <div class="d-flex align-items-center">
            <!-- ✅ Clochette notifications -->
            <button type="button" class="btn position-relative me-3" data-bs-toggle="modal" data-bs-target="#modalDemandes">
                🔔
                <?php if ($demandes_attente > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $demandes_attente ?>
                        <span class="visually-hidden">demandes en attente</span>
                    </span>
                <?php endif; ?>
            </button>

            <!-- ✅ Déconnexion -->
            <a href="logout_admin.php" class="btn btn-outline-light">Déconnexion</a>
        </div>
    </div>
</nav>

<!-- ✅ Modal des demandes -->
<div class="modal fade" id="modalDemandes" tabindex="-1" aria-labelledby="modalDemandesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDemandesLabel">📋 Demandes en attente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <?php
        // ✅ Charger les demandes en attente
        $stmt = $pdo->query("
            SELECT d.*, e.nom AS nom_etudiant, e.prenom, c.nom AS nom_club
            FROM demandes_adhesion d
            JOIN etudiants e ON d.etudiant_id = e.id
            JOIN clubs c ON d.club_id = c.id
            WHERE d.statut = 'en attente'
            ORDER BY d.date_demande DESC
        ");
        $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($demandes)): ?>
            <p class="text-center">Aucune demande en attente.</p>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($demandes as $demande): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($demande['prenom'] . ' ' . $demande['nom_etudiant']) ?></strong> souhaite rejoindre <strong><?= htmlspecialchars($demande['nom_club']) ?></strong>
                        <a href="demandes_admin.php" class="btn btn-sm btn-primary float-end">Voir</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
