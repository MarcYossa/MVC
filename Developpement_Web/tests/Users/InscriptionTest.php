<?php
require_once '../config/database.php';
require_once '../models/User/Inscription.php';

function testInscrire() {
    $inscription = new Inscription();

    // 1. Test d'inscription avec des données valides
    $id_utilisateur = 'User0100';  // ID utilisateur fictif
    $id_parrain = null;             // Pas de parrain pour ce test
    $code_parrainage = null;        // Pas de code de parrainage
    $nom_u = 'MR';           // Nom de l'utilisateur
    $email = 'MR@example.com'; // Email fictif à tester
    $tel = '655322265';            // Numéro de téléphone fictif
    $status_compte = 'actif';       // Statut du compte
    $mot_de_passe = 'QSD';  // Mot de passe à tester

    try {
        $id_compte = $inscription->inscrire($id_utilisateur, $id_parrain, $code_parrainage, $nom_u, $email, $tel, $status_compte, $mot_de_passe);
        echo "Test d'inscription avec données valides : Succès, ID Compte : $id_compte\n";
    } catch (Exception $e) {
        echo "Test d'inscription avec données valides : Échec - " . $e->getMessage() . "\n";
    }

    // 2. Test d'inscription avec un email déjà utilisé
    try {
        $inscription->inscrire($id_utilisateur, $id_parrain, $code_parrainage, 'marcoyossa425@gmail.com', $email, $tel, $status_compte, $mot_de_passe);
        echo "Test d'inscription avec email déjà utilisé : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test d'inscription avec email déjà utilisé : Succès - " . $e->getMessage() . "\n";
    }

    // 3. Test d'inscription avec un email invalide
    try {
        $inscription->inscrire($id_utilisateur, $id_parrain, $code_parrainage, 'Invalid User', 'marcoyossa425@gmai.co', $tel, $status_compte, $mot_de_passe);
        echo "Test d'inscription avec email invalide : Échec - aucune exception lancée\n";
    } catch (Exception $e) {
        echo "Test d'inscription avec email invalide : Succès - " . $e->getMessage() . "\n";
    }
}

// Exécuter le test
testInscrire();
?>