<?php
// ParrainageCRUD.php

require 'db.php'; // Inclure le fichier de connexion à la base de données
require_once __DIR__ . '/../Parrainage.php'; // Chemin vers Panier.php
require_once 'Id.php';


// Créer un nouveau parrainage
function creerParrainage($pdo, $id_parrain, $id_filleul, $etat) {
    // Création d'un nouvel objet Parrainage
    $parrainage = new Parrainage($pdo, $id_parrain, $id_filleul, null, $etat);
    return $parrainage->enregistrer(); // Appeler la méthode d'enregistrement
}

// Lire un parrainage par ID de parrain
function lireParrainage($pdo, $id_parrain) {
    // Préparer la requête SQL pour obtenir les parrainages
    $query = "SELECT * FROM Parrainage WHERE ID_parrain = ?";
    $stmt = $pdo->prepare($query); // Préparer la requête
    $stmt->execute([$id_parrain]); // Exécuter la requête avec l'ID du parrain
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner tous les parrainages sous forme de tableau associatif
}

// Supprimer un parrainage
function supprimerParrainage($pdo, $id_parrain, $id_filleul) {
    // Préparer la requête SQL pour supprimer un parrainage
    $query = "DELETE FROM Parrainage WHERE ID_parrain = ? AND ID_filleul = ?";
    $stmt = $pdo->prepare($query); // Préparer la requête
    return $stmt->execute([$id_parrain, $id_filleul]); // Exécuter la requête et retourner le résultat
}
?>