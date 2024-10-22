<?php
session_start(); // Démarrer la session pour gérer les messages d'erreur

// Afficher les messages d'erreur (si disponibles)
if (isset($_SESSION['error'])) {
    echo "<p class='error'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']); // Supprimer le message après l'affichage
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de Mot de Passe</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <div class="container">
        <h2>Réinitialiser votre Mot de Passe</h2>
        <form action="../views/ResetPassword_process.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="new_password">Nouveau Mot de Passe:</label>
            <input type="password" id="new_password" name="new_password" required>

            <button type="submit">Réinitialiser</button>
        </form>
    </div>
</body>
</html>