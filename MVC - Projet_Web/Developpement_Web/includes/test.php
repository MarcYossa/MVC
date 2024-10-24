<?php
require_once __DIR__ . '/db.php'; // Chemin vers db.php
require_once __DIR__ . '/config.php'; // Chemin vers config.php
require_once __DIR__ . '/../models/Panier.php'; // Chemin vers Panier.php
require_once __DIR__ . '/../models/fonctions/PasserCommande.php'; // Chemin vers PasserCommande.php

$id_utilisateur = 'U101'; // Remplace par l'ID d'un utilisateur existant
$code_parrain = null; // Ou remplace par l'ID d'un parrain existant si nécessaire
$montant = 5000; // Montant de la commande
$pt_accumule = 10; // Points à accumuler

// Obtention de la connexion à la base de données
$db = Database::getInstance();
$pdo = $db->getConnection(); // Récupération de la connexion PDO

// Vérification de l'existence de l'utilisateur
$stmt = $pdo->prepare("SELECT COUNT(*) FROM Utilisateurs WHERE ID_utilisateur = ?"); // Assurez-vous que la table s'appelle 'Utilisateurs'
$stmt->execute([$id_utilisateur]);
if ($stmt->fetchColumn() == 0) {
    die("Erreur : L'utilisateur $id_utilisateur n'existe pas.");
}

// Validation des montants
if ($montant <= 0) {
    die("Erreur : Le montant doit être supérieur à zéro.");
}
if ($pt_accumule < 0) {
    die("Erreur : Les points accumulés ne peuvent pas être négatifs.");
}

// Appel de la fonction passerCommande
try {
    $id_commande = passerCommande($pdo, $id_utilisateur, $montant, $code_parrain = null, $pt_accumule, 'P101', 'sur place', 'en attente', 'bonjour');
    echo "Commande passée avec succès, ID commande : " . $id_commande . PHP_EOL;
} catch (Exception $e) {
    echo "Erreur lors de la commande pour l'utilisateur $id_utilisateur : " . $e->getMessage() . PHP_EOL;
}

// Vérifier les points de l'utilisateur
$stmt = $pdo->prepare("SELECT Point_fidelite FROM Utilisateurs WHERE ID_utilisateur = ?"); // Assurez-vous que la table s'appelle 'Utilisateurs'
$stmt->execute([$id_utilisateur]);
$points_utilisateur = $stmt->fetchColumn();
echo "Points de fidélité restants pour l'utilisateur $id_utilisateur : " . $points_utilisateur . PHP_EOL;

?>


