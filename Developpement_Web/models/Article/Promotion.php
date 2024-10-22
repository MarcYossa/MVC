<?php
require_once '../models/Article.php';

class Promotion {
    private $articleModel;

    public function __construct() {
        $this->articleModel = new Article_Promo();
    }

    // Appliquer une promotion à un article
    public function applyPromotion($id, $discountPercentage) {
        $article = $this->articleModel->read($id);
        if (!$article) {
            throw new Exception("Article non trouvé.");
        }

        $currentPrice = $article['price'];
        $newPrice = $currentPrice - ($currentPrice * ($discountPercentage / 100));

        if ($this->articleModel->updatePrice($id, $newPrice)) {
            return $newPrice;
        }
        throw new Exception("La mise à jour du prix a échoué.");
    }

    // Appliquer une promotion à tous les articles
    public function applyPromotionToAll($discountPercentage) {
        $articles = $this->articleModel->readAll();
        foreach ($articles as $article) {
            $this->applyPromotion($article['id'], $discountPercentage);
        }
    }
}
?>