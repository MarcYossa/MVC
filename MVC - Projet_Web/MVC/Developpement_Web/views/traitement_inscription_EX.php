<?php
// traitement_inscription.php

require_once '../config/database.php'; // Inclure la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id_utilisateur = $_POST['id_utilisateur'];
    $id_parrain = $_POST['id_parrain'] ?: null; // Si vide, mettre à NULL
    $code_parrainage = $_POST['code_parrainage'] ?: null; // Si vide, mettre à NULL
    $nom_u = $_POST['nom_u'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $status_compte = $_POST['status_compte'];
    
    // Vérifier si le mot de passe est fourni
    if (!isset($_POST['mot_de_passe']) || empty($_POST['mot_de_passe'])) {
        echo "Erreur : Le mot de passe ne peut pas être vide.";
        exit();
    }
    
    $mot_de_passe = $_POST['mot_de_passe']; // Récupérer le mot de passe

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Erreur : L'email est invalide.";
        exit();
    }

    // Démarrer une transaction
    $pdo->beginTransaction();

    try {
        // Hachage du mot de passe avant stockage
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        
        // Insérer un nouveau compte pour obtenir l'ID auto-incrémenté
        $stmtCompte = $pdo->prepare("INSERT INTO Compte (role, mot_de_passe, email) VALUES (?, ?, ?)");
        $stmtCompte->execute(['client', $hashed_password, $email]);
        $id_auto = $pdo->lastInsertId(); // Récupérer l'ID auto-incrémenté

        // Générer l'ID_compte avec le préfixe 'CLI'
        $prefix = 'CLI';
        $id_compte = $prefix . str_pad($id_auto, 5, '0', STR_PAD_LEFT); // Ajouter 5 zéros devant

        // Mettre à jour l'ID_compte dans la table Compte
        $updateStmt = $pdo->prepare("UPDATE Compte SET ID_compte = ? WHERE id_auto = ?");
        $updateStmt->execute([$id_compte, $id_auto]);

        // Préparer la requête d'insertion pour Utilisateurs
        $stmtUtilisateur = $pdo->prepare("INSERT INTO Utilisateurs (ID_utilisateur, ID_parrain, ID_compte, Code_parrainage, Nom_u, Email, Tel, Status_compte) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Exécuter la requête pour Utilisateurs
        $stmtUtilisateur->execute([$id_utilisateur, $id_parrain, $id_compte, $code_parrainage, $nom_u, $email, $tel, $status_compte]);

        // Valider la transaction
        $pdo->commit();
        echo "Inscription réussie ! Votre ID de compte est : " . $id_compte;
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        echo "Erreur : " . $e->getMessage(); // Afficher l'erreur pour le débogage
    }
} else {
    echo "Méthode de requête non supportée.";
}
?>