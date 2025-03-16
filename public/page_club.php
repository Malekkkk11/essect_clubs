<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($club['nom']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f1f1;
        }

        .club-cover {
            height: 350px;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            position: relative;
            margin-bottom: 80px;
        }

        .club-logo {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
            position: absolute;
            bottom: -70px;
            left: 20px;
            background: white;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .card-info {
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            color: white;
        }

        .membres { background: #007bff; }
        .objectif { background: #17a2b8; }
        .valeur { background: #ffc107; }
        .description { background: #6f42c1; }
        .date { background: #28a745; }
        .reseaux { background: #dc3545; }

        .card-info h5 {
            margin-bottom: 15px;
            color: white;
        }

        .info-item {
            margin-bottom: 12px;
        }

        .info-item img {
            width: 20px;
            margin-right: 8px;
            vertical-align: middle;
        }

        .info-item a {
            color: white;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-<?= $_GET['message'] == 'success' ? 'success' : 'danger' ?> text-center mt-3">
        <?php if ($_GET['message'] == 'success'): ?>
            ✅ Votre demande d'adhésion a bien été envoyée !
        <?php elseif ($_GET['message'] == 'exist'): ?>
            ⚠️ Vous avez déjà fait une demande pour ce club.
        <?php elseif ($_GET['message'] == 'cv_type_error'): ?>
            ❌ Seuls les fichiers PDF sont acceptés.
        <?php elseif ($_GET['message'] == 'cv_upload_error'): ?>
            ❌ Problème lors de l'upload du CV. Réessayez.
        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="container mt-5">
    <a href="dashboard_etudiant_process.php" class="btn btn-secondary mb-4">⬅ Retour</a>

    <!-- ✅ Image de couverture -->
    <?php if (!empty($club['images'])): ?>
        <div class="club-cover" style="background-image: url('/clubs_essect/<?= htmlspecialchars($club['images']) ?>');">
            <?php if (!empty($club['logo'])): ?>
                <img src="/clubs_essect/<?= htmlspecialchars($club['logo']) ?>" alt="Logo Club" class="club-logo">
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- ✅ Nom et Catégorie -->
    <h1 class="fw-bold mt-5"><?= htmlspecialchars($club['nom']) ?></h1>
    <h5 class="text-muted"><?= htmlspecialchars($club['categorie']) ?></h5>
    <div>
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalDemande">
            💌 Rejoindre ce club
        </button>
    </div>
    <!-- ✅ MODAL avec formulaire -->
<div class="modal fade" id="modalDemande" tabindex="-1" aria-labelledby="modalDemandeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="demande_adhesion_process.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDemandeLabel">💌 Demande d'adhésion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="club_id" value="<?= htmlspecialchars($club['id']) ?>">

                    <div class="mb-3">
                        <label for="motivation" class="form-label">Message de motivation *</label>
                        <textarea name="motivation" id="motivation" class="form-control" rows="4" required placeholder="Pourquoi souhaitez-vous rejoindre ce club ?"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="cv" class="form-label">Joindre votre CV (PDF uniquement) *</label>
                        <input type="file" name="cv" id="cv" class="form-control" accept="application/pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer ma demande</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- ✅ GRID DESIGN -->
    <div class="grid mt-4">

        <!-- ✅ Carte Membres -->
        <div class="card-info membres">
            <h5>Membres</h5>
            <?php if (!empty($club['president'])): ?>
                <p class="info-item">👤 Président : <?= htmlspecialchars($club['president']) ?></p>
            <?php endif; ?>
            <?php if (!empty($club['vice_president'])): ?>
                <p class="info-item">🤝 Vice-Président : <?= htmlspecialchars($club['vice_president']) ?></p>
            <?php endif; ?>
            <?php if (!empty($club['nombre_membres'])): ?>
                <p class="info-item">👥 Membres : <?= htmlspecialchars($club['nombre_membres']) ?></p>
            <?php endif; ?>
        </div>

        <!-- ✅ Carte Objectifs -->
        <?php if (!empty($club['objectif'])): ?>
            <div class="card-info objectif">
                <h5>Objectifs</h5>
                <p class="info-item"><?= nl2br(htmlspecialchars($club['objectif'])) ?></p>
            </div>
        <?php endif; ?>

        <!-- ✅ Carte Valeurs -->
        <?php if (!empty($club['valeur'])): ?>
            <div class="card-info valeur">
                <h5>Valeurs</h5>
                <p class="info-item"><?= nl2br(htmlspecialchars($club['valeur'])) ?></p>
            </div>
        <?php endif; ?>

        <!-- ✅ Carte Description -->
        <?php if (!empty($club['description'])): ?>
            <div class="card-info description">
                <h5>Présentation</h5>
                <p class="info-item"><?= nl2br(htmlspecialchars($club['description'])) ?></p>
            </div>
        <?php endif; ?>

        <!-- ✅ Carte Date -->
        <?php if (!empty($club['date_creation'])): ?>
            <div class="card-info date">
                <h5>Date de création</h5>
                <p class="info-item">📅 <?= htmlspecialchars($club['date_creation']) ?></p>
            </div>
        <?php endif; ?>

        <!-- ✅ Carte Réseaux -->
        <?php if (!empty($club['lien_facebook']) || !empty($club['lien_instagram']) || !empty($club['lien_tiktok'])): ?>
            <div class="card-info reseaux">
                <h5>Réseaux Sociaux</h5>
                <?php if (!empty($club['lien_facebook'])): ?>
                    <p class="info-item">
                        <img src="/clubs_essect/icons/facebook.png" alt="Facebook"> 
                        <a href="<?= htmlspecialchars($club['lien_facebook']) ?>" target="_blank">Page Facebook</a>
                    </p>
                <?php endif; ?>
                <?php if (!empty($club['lien_instagram'])): ?>
                    <p class="info-item">
                        <img src="/clubs_essect/icons/instagram.png" alt="Instagram"> 
                        <a href="<?= htmlspecialchars($club['lien_instagram']) ?>" target="_blank">Page Instagram</a>
                    </p>
                <?php endif; ?>
                <?php if (!empty($club['lien_tiktok'])): ?>
                    <p class="info-item">
                        <img src="/clubs_essect/icons/tiktok.png" alt="TikTok"> 
                        <a href="<?= htmlspecialchars($club['lien_tiktok']) ?>" target="_blank">Page TikTok</a>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div> <!-- End Grid -->

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
