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
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <div class="container">
        <h2>Créer un compte</h2>
        <form action="traitement_inscription.php" method="POST">
            <label for="id_utilisateur">ID Utilisateur:</label>
            <input type="text" id="id_utilisateur" name="id_utilisateur" required>

            <label for="id_parrain">ID Parrain (optionnel):</label>
            <input type="text" id="id_parrain" name="id_parrain">

            <label for="code_parrainage">Code Parrainage (optionnel):</label>
            <input type="text" id="code_parrainage" name="code_parrainage">

            <label for="nom_u">Nom:</label>
            <input type="text" id="nom_u" name="nom_u" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="tel">Téléphone:</label>
            <input type="tel" id="tel" name="tel" required>

            <label for="status_compte">Statut du Compte:</label>
            <select id="status_compte" name="status_compte" required>
                <option value="actif">Actif</option>
                <option value="inactif">Inactif</option>
            </select>

            <label for="mot_de_passe">Mot de Passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>