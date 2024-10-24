<?php
session_start(); // Démarrer la session pour gérer les messages d'erreur

// Afficher les messages d'erreur (si disponibles)
if (isset($_SESSION['error'])) {
    echo "<p class='error'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']); // Supprimer le message après l'affichage
}

// Afficher le message de déconnexion réussie (si disponible)
if (isset($_SESSION['success'])) {
    echo "<p class='success'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']); // Supprimer le message après l'affichage
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form action="login_process.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="mot_de_passe">Mot de Passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>

            <button type="submit">Se connecter</button>
            <p><a href="../views/ResetPassword.php">Mot de passe oublié ?</a></p> <!-- Lien vers la page de réinitialisation -->
        </form>
    </div>
</body>
</html>