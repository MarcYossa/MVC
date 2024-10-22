<?php
require_once '../config/database.php';
require_once '../models/Compte_Employee/Ajout.php';

function testAjouterEmploye() {
    $ajout = new Ajout();

    // 1. Test d'ajout d'employé avec des données valides
    $emailValide = 'RN.BN@gmail.com'; // Email fictif
    $motDePasseValide = 'ATYui123';     // Mot de passe fictif

    try {
        $resultat = $ajout->ajouterEmploye($emailValide, $motDePasseValide);
        echo "Test d'ajout d'employé avec données valides : Succès\n";
    } catch (Exception $e) {
        echo "Test d'ajout d'employé avec données valides : Échec - " . $e->getMessage() . "\n";
    }

    // 2. Test d'ajout d'employé avec un email déjà utilisé
    try {
        $ajout->ajouterEmploye($emailValide, 'anotherpassword');
        echo "Test d'ajout d'employé avec email déjà utilisé : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test d'ajout d'employé avec email déjà utilisé : Succès - " . $e->getMessage() . "\n";
    }

    // 3. Test d'ajout d'employé avec un email invalide
    try {
        $ajout->ajouterEmploye('invalid-email', $motDePasseValide);
        echo "Test d'ajout d'employé avec email invalide : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test d'ajout d'employé avec email invalide : Succès - " . $e->getMessage() . "\n";
    }
}

// Exécuter le test
testAjouterEmploye();
?>