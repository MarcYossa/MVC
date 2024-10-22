<?php

require_once '../config/database.php'; // Assurez-vous que le chemin est correct
require_once '../modelsArticle/Jeu.php'; // Assurez-vous que le chemin est correct
require_once '../controllers/JeuController.php'; // Assurez-vous que le chemin est correct

function testAjouterJeu() {
    // Simuler l'instance de JeuController
    $jeuController = new JeuController();

    // Test d'ajout de jeu avec des données valides
    $_POST['image'] = 'http://example.com/image.jpg'; // URL d'image valide

    try {
        ob_start(); // Commencez à capturer la sortie
        $jeuController->ajouterJeu();
        $output = ob_get_clean(); // Capturer la sortie et nettoyer le tampon
        echo "Test d'ajout de jeu avec données valides : Succès\n";
        echo "Sortie : $output\n";
    } catch (Exception $e) {
        echo "Test d'ajout de jeu avec données valides : Échec - " . $e->getMessage() . "\n";
    }

    // Test d'ajout de jeu sans image
    unset($_POST['image']); // Supprimer l'image pour simuler une entrée invalide

    try {
        ob_start(); // Commencez à capturer la sortie
        $jeuController->ajouterJeu();
        $output = ob_get_clean(); // Capturer la sortie et nettoyer le tampon
        echo "Test d'ajout de jeu sans image : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test d'ajout de jeu sans image : Succès - " . $e->getMessage() . "\n";
    }
}

// Exécuter le test
testAjouterJeu();
?>