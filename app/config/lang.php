<?php
// app/config/lang.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Vérifie si la langue est définie en session, sinon met par défaut 'fr'
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'fr';
}

// ✅ Récupérer la langue actuelle
$lang = $_SESSION['lang'];

echo "🌍 Langue actuelle : " . $lang . "<br>";

// 🌐 Traductions
$translations = [
    'fr' => [
        'dashboard_title' => 'Tableau de bord étudiant',
        'welcome' => 'Bienvenue',
        'logout' => 'Déconnexion',
        'my_profile' => 'Mon Profil',
        'clubs_available' => 'Clubs Disponibles',
        'my_clubs' => 'Mes Clubs',
        'my_requests' => 'Mes Demandes d\'adhésion',
        'copyright' => '© 2025 - Tous droits réservés',
        'show club' => 'Voir le Club'
    ],
    'en' => [
        'dashboard_title' => 'Student Dashboard',
        'welcome' => 'Welcome',
        'logout' => 'Logout',
        'my_profile' => 'My Profile',
        'clubs_available' => 'Available Clubs',
        'my_clubs' => 'My Clubs',
        'my_requests' => 'My Join Requests',
        'copyright' => '© 2025 - All rights reserved',
        'show club' => 'Show the club'
    ]
];

// ✅ Fonction de traduction
function t($key) {
    global $translations, $lang;
    return $translations[$lang][$key] ?? $key;
}

// ✅ Test pour voir si la traduction fonctionne
echo "🔍 Test traduction (welcome) : " . t('welcome') . "<br>";
?>