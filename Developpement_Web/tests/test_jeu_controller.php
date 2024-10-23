<?php
// Commencez le tampon de sortie
ob_start();

require_once '../config/database.php';
require_once '../models/Jeu.php';
require_once '../controllers/JeuController.php';

function testAjouterJeu() {
    $jeuController = new JeuController();

    // Test d'ajout de jeu avec des données valides
    $_POST['titre'] = 'Mon Jeu';
    $_POST['description'] = 'Description de mon jeu';
    $_FILES['image'] = [
        'name' => 'istockphoto-1428750235-612x612.jpg',
        'type' => 'image/jpeg',
        'tmp_name' => 'c:/path/to/temp/istockphoto-1428750235-612x612.jpg',
        'error' => 0,
        'size' => 12345
    ];

    try {
        ob_start(); // Commencez à capturer la sortie
        $jeuController->addJeu();
        $output = ob_get_clean(); // Capturer la sortie et nettoyer le tampon
        echo "Test d'ajout de jeu avec données valides : Succès\n";
        echo "Sortie : $output\n";
    } catch (Exception $e) {
        echo "Test d'ajout de jeu avec données valides : Échec - " . $e->getMessage() . "\n";
    }

    // Test d'ajout de jeu sans image
    unset($_FILES['image']);

    try {
        ob_start();
        $jeuController->addJeu();
        $output = ob_get_clean();
        echo "Test d'ajout de jeu sans image : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test d'ajout de jeu sans image : Succès - " . $e->getMessage() . "\n";
    }
}

// Exécuter le test
testAjouterJeu();
ob_end_flush(); // Nettoie le tampon et affiche la sortie
?>