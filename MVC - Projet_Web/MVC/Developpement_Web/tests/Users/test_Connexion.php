<?php
require_once '../config/database.php';
require_once '../models/User/Connexion.php';

function testConnecter() {
    $connexion = new Connexion();

    // 1. Test de connexion avec des identifiants valides
    $emailValide = 'marc.ngoukam@2028.ucac-icam.com'; // Remplacez par un email valide dans votre base de données
    $motDePasseValide = 'AZERTY'; // Remplacez par le mot de passe associé à l'email ci-dessus

    try {
        $idCompte = $connexion->connecter($emailValide, $motDePasseValide);
        echo "Test de connexion avec identifiants valides : Succès, ID Compte : $idCompte\n";
    } catch (Exception $e) {
        echo "Test de connexion avec identifiants valides : Échec - " . $e->getMessage() . "\n";
    }

    // 2. Test de connexion avec des identifiants invalides
    $emailInvalide = 'invalide@example.com'; // Remplacez par un email qui n'existe pas
    $motDePasseInvalide = 'wrongpassword'; // Mot de passe incorrect

    try {
        $connexion->connecter($emailInvalide, $motDePasseInvalide);
        echo "Test de connexion avec identifiants invalides : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test de connexion avec identifiants invalides : Succès - " . $e->getMessage() . "\n";
    }
}

// Exécuter le test
testConnecter();
?>