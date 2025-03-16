


<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\LoginController;

$controller = new LoginController();

session_start();
require_once 'C:\xampp\htdocs\clubs_essect\app\controllers\LoginController.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $auth = new LoginController();
    $message = $auth->login($email, $password, $role);

    if ($message === "Connexion réussie.") {
        header("Location: dashboard.php"); // Rediriger après connexion
        exit();
    } else {
        echo "<p style='color:red;'>$message</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <select name="role">
            <option value="etudiant">Étudiant</option>
            <option value="admin">Administrateur</option>
        </select><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>


