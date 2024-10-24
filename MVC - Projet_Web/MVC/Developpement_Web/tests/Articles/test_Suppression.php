<?php
require_once '../config/database.php';
require_once '../models/Article/Suppression.php';

function testSupprimerArticle() {
    $suppression = new Suppression();
    $id_plat = 'PLT12345'; // Assurez-vous que cet ID existe déjà dans votre base de données

    // 1. Vérifier que l'article existe avant la suppression
    $stmt = Database::getConnection()->prepare("SELECT COUNT(*) FROM Article WHERE ID_plat = ?");
    $stmt->execute([$id_plat]);
    $existsBefore = $stmt->fetchColumn() > 0;

    if ($existsBefore) {
        echo "L'article existe avant la suppression.\n";

        // 2. Test de suppression de l'article
        try {
            $suppression->supprimerArticle($id_plat);
            echo "Test de suppression : Succès\n";
        } catch (Exception $e) {
            echo "Test de suppression : Échec - " . $e->getMessage() . "\n";
            return;
        }

        // 3. Vérifier que l'article n'existe plus après la suppression
        $stmt->execute([$id_plat]);
        $existsAfter = $stmt->fetchColumn() > 0;

        if (!$existsAfter) {
            echo "L'article a été supprimé avec succès.\n";
        } else {
            echo "Échec de la suppression : l'article existe toujours.\n";
        }
    } else {
        echo "L'article n'existe pas dans la base de données avant la suppression.\n";
    }
}

// Exécuter le test
testSupprimerArticle();
?>