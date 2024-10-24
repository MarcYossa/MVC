<?php
require_once '../config/database.php';
require_once '../models/Jeu.php'; // Assurez-vous que le chemin est correct

// Fonction de test simple
function testJeu() {
    // Créer une instance de la classe Jeu
    $jeu = new Jeu();

    // Test d'ajout d'un nouveau jeu
    $titre = 'MoaJeu';
    $description = 'Description';
    $image = 'c:\Users\User\Documents\istockphoto-1428750235-612x612.jpg'; // Simulez un nom d'image

    // Ajout du jeu
    $idJeu = $jeu->ajouterJeu($titre, $description, $image);
    
    if ($idJeu) {
        echo "Test d'ajout de jeu : Succès - ID du jeu ajouté : $idJeu\n";
    } else {
        echo "Test d'ajout de jeu : Échec\n";
    }

    // Test de lecture de tous les jeux
    $jeux = $jeu->readAll();
    
    if ($jeux) {
        echo "Test de lecture de tous les jeux : Succès\n";
        print_r($jeux); // Affiche les jeux
    } else {
        echo "Test de lecture de tous les jeux : Échec\n";
    }
}

// Exécuter le test
testJeu();
?>