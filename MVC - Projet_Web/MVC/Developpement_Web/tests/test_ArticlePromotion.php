<?php
require_once '../models/Aticle/Article_Promotion.php'; // Assurez-vous que le chemin est correct

try {
    // Instanciation de la classe
    $articlePromotion = new ArticlePromotion();

    // 1. Ajouter un nouvel article
    echo "Ajout d'un nouvel article...\n";
    $articleId = $articlePromotion->saveArticle('Titre de l\'article', 'Description de l\'article', 100.00, 'PLT', true);
    echo "Article ajouté avec l'ID : $articleId\n";

    // 2. Lire tous les articles
    echo "Lecture de tous les articles...\n";
    $articles = $articlePromotion->readAll();
    print_r($articles);

    // 3. Appliquer une promotion
    echo "Application d'une promotion de 20%...\n";
    $newPrice = $articlePromotion->applyPromotion($articleId, 20, '2024-10-01 00:00:00', '2024-10-31 23:59:59');
    echo "Nouveau prix après promotion : $newPrice\n";

    // 4. Vérifier si l'article est en promotion
    echo "Vérification de la promotion...\n";
    if ($articlePromotion->isArticleOnPromotion($articleId)) {
        echo "L'article est actuellement en promotion.\n";
    } else {
        echo "L'article n'est pas en promotion.\n";
    }

    // 5. Obtenir le prix final
    echo "Obtention du prix final...\n";
    $finalPrice = $articlePromotion->getFinalPrice($articleId);
    echo "Prix final : $finalPrice\n";

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
?>