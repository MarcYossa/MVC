<?php

require_once '../models/Article.php'; // Assurez-vous que le chemin est correct
require_once '../models/Article/Promotion.php'; // Assurez-vous que le chemin est correct

function testApplyPromotion() {
    $promotion = new Promotion();

    // Test d'application d'une promotion sur un article existant
    $articleIdValide = 1; // Remplacez par un ID d'article valide dans votre base de données
    $pourcentageReduction = 20; // Pourcentage de réduction

    try {
        $nouveauPrix = $promotion->applyPromotion($articleIdValide, $pourcentageReduction);
        echo "Test d'application de promotion sur un article existant : Succès, Nouveau Prix : $nouveauPrix\n";
    } catch (Exception $e) {
        echo "Test d'application de promotion sur un article existant : Échec - " . $e->getMessage() . "\n";
    }

    // Test d'application d'une promotion sur un article inexistant
    $articleIdInvalide = 999; // ID d'article qui n'existe pas

    try {
        $promotion->applyPromotion($articleIdInvalide, $pourcentageReduction);
        echo "Test d'application de promotion sur un article inexistant : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test d'application de promotion sur un article inexistant : Succès - " . $e->getMessage() . "\n";
    }
}

function testApplyPromotionToAll() {
    $promotion = new Promotion();

    // Test d'application d'une promotion à tous les articles
    $pourcentageReduction = 10; // Pourcentage de réduction

    try {
        $promotion->applyPromotionToAll($pourcentageReduction);
        echo "Test d'application de promotion à tous les articles : Succès\n";
    } catch (Exception $e) {
        echo "Test d'application de promotion à tous les articles : Échec - " . $e->getMessage() . "\n";
    }
}

// Exécuter les tests
testApplyPromotion();
testApplyPromotionToAll();
?>