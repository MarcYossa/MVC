<?php
// traitement_inscription.php

require_once '../config/database.php'; // Inclure la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id_utilisateur = $_POST['id_utilisateur'];
    $id_parrain = $_POST['id_parrain'];
    $id_compte = $_POST['id_compte'];
    $code_parrainage = $_POST['code_parrainage'];
    $nom_u = $_POST['nom_u'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hashage du mot de passe
    $status_compte = $_POST['status_compte'];

    // Préparer la requête d'insertion
    $stmt = $pdo->prepare("INSERT INTO Utilisateurs (ID_utilisateur, ID_parrain, ID_compte, Code_parrainage, Nom_u, Email, Tel, Mot_de_passe, Status_compte) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Exécuter la requête
    if ($stmt->execute([$id_utilisateur, $id_parrain, $id_compte, $code_parrainage, $nom_u, $email, $tel, $mot_de_passe, $status_compte])) {
        echo "Inscription réussie !";
        // Rediriger ou afficher un message de succès
    } else {
        echo "Erreur lors de l'inscription.";
    }
} else {
    echo "Méthode de requête non supportée.";
}
?>