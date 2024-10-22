<?php
require_once '../config/database.php';
require_once '../models/Compte_Employee/Modify.php';

function testUpdatePasswordEmp() {
    $modify = new Modify();

    // 1. Test de mise à jour du mot de passe avec un email valide
    $emailValide = 'marc.ngoukam@2028.ucac-icam.com'; // Remplacez par un email d'un employé existant
    $nouveauMotDePasse = 'AZERTY'; // Nouveau mot de passe à tester

    try {
        $resultat = $modify->updatePasswordEmp($emailValide, $nouveauMotDePasse);
        echo "Test de mise à jour du mot de passe avec un email valide : Succès\n";
    } catch (Exception $e) {
        echo "Test de mise à jour du mot de passe avec un email valide : Échec - " . $e->getMessage() . "\n";
    }

    // 2. Test de mise à jour du mot de passe avec un email non existant
    $emailInvalide = 'nonexistent@example.com'; // Email qui n'existe pas dans la base de données

    try {
        $modify->updatePasswordEmp($emailInvalide, 'anotherpassword');
        echo "Test de mise à jour du mot de passe avec un email non existant : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test de mise à jour du mot de passe avec un email non existant : Succès - " . $e->getMessage() . "\n";
    }
}

// Exécuter le test
testUpdatePasswordEmp();
?>