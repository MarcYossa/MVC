<?php
require_once '../config/database.php';
require_once '../models/Article/Creation.php';

function testAjouterArticle() {
    $creation = new Creation();
    $success = false;

    // 1. Test d'un ajout valide
    try {
        $success = $creation->ajouterArticle('PLT123456', 'Plat Test', 'Description du plat', 15.5, true);
        echo "Test 1 (ajout valide) : " . ($success ? "Succès" : "Échec") . "\n";
    } catch (Exception $e) {
        echo "Test 1 (ajout valide) : Échec - " . $e->getMessage() . "\n";
    }

    // 2. Test d'un ID_Article invalide
    try {
        $creation->ajouterArticle('INVALID_ID', 'Plat Invalide', 'Description invalide', 10.0, true);
        echo "Test 2 (ID_Article invalide) : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test 2 (ID_Article invalide) : Succès - " . $e->getMessage() . "\n";
    }

    // 3. Test d'un ID_Article déjà existant
    try {
        // Ajout d'un article pour préparer le doublon
        $creation->ajouterArticle('PLT123456', 'Plat Doublon', 'Description du doublon', 20.0, true);
        echo "Test 3 (ID_Article déjà existant) : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test 3 (ID_Article déjà existant) : Succès - " . $e->getMessage() . "\n";
    }

    // 4. Test d'un ajout avec un ID valide mais déjà utilisé
    try {
        $creation->ajouterArticle('BOI654321', 'Boisson Test', 'Description de la boisson', 5.0, true);
        echo "Test 4 (ajout valide pour BOI) : Succès\n";
    } catch (Exception $e) {
        echo "Test 4 (ajout valide pour BOI) : Échec - " . $e->getMessage() . "\n";
    }
}

// Exécuter les tests
testAjouterArticle();
?>