<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard_etudiant_process.php">Mon Espace Étudiant</a>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="ms-2"><?= $_SESSION['etudiant']['prenom'] ?? 'Utilisateur' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profilModal">👤 Mon Profil</a>
                </li>
                <li><a class="dropdown-item" href="logout.php">🚪 Déconnexion</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ MODALE PROFIL -->
<div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="profilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profilModalLabel">👤 Mon Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body text-center">
        <!-- ✅ Photo de profil -->
        <img src="<?= !empty($etudiant['photo']) ? htmlspecialchars($etudiant['photo']) : 'https://via.placeholder.com/150' ?>" 
             alt="Photo Profil" 
             class="rounded-circle mb-3" 
             style="width: 120px; height: 120px; object-fit: cover;">

        <!-- ✅ Infos étudiant -->
        <p><strong>Nom :</strong> <?= htmlspecialchars($etudiant['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($etudiant['prenom']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($etudiant['email']) ?></p>
        <p><strong>Classe :</strong> <?= htmlspecialchars($etudiant['class']) ?></p>
        <p><strong>Date d'inscription :</strong> <?= htmlspecialchars($etudiant['date_inscription']) ?></p>
      </div>
    </div>
  </div>
</div>

