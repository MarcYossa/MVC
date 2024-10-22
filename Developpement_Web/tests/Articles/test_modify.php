<?php
require_once '../config/database.php';
require_once '../models/Article/Modify.php';

function testModifierArticle() {
    $modify = new Modify();
    $id_plat = 'PLT12345'; // Assurez-vous que cet ID existe déjà dans votre base de données

    // 1. Test d'obtention de l'article avant modification
    $articleAvant = $modify->obtenirArticle($id_plat);
    echo "Article avant modification : \n";
    print_r($articleAvant);

    // 2. Test de modification de l'article
    try {
        $modify->modifierArticle($id_plat, 'Plat Modifié', 'Nouvelle description', 20.0, 1);
        echo "Test de modification : Succès\n";
    } catch (Exception $e) {
        echo "Test de modification : Échec - " . $e->getMessage() . "\n";
    }

    // 3. Test d'obtention de l'article après modification
    $articleApres = $modify->obtenirArticle($id_plat);
    echo "Article après modification : \n";
    print_r($articleApres);

    // Vérifier que les données ont été mises à jour
    if ($articleApres['nom_m'] === 'Plat Modifié' && $articleApres['description_m'] === 'Nouvelle description' && $articleApres['Prix'] == 20.0) {
        echo "Test de vérification des modifications : Succès\n";
    } else {
        echo "Test de vérification des modifications : Échec\n";
    }
}

// Exécuter le test
testModifierArticle();
?>