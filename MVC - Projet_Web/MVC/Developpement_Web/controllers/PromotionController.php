<?php
require_once '../models/Promotion.php';

class PromotionController {
    private $promotionModel;

    public function __construct() {
        $this->promotionModel = new Promotion();
    }

    // Appliquer une promotion à un article
    public function applyPromotionToArticle($id, $discountPercentage) {
        return $this->promotionModel->applyPromotion($id, $discountPercentage);
    }

    // Appliquer une promotion à tous les articles
    public function applyPromotionToAllArticles($discountPercentage) {
        return $this->promotionModel->applyPromotionToAll($discountPercentage);
    }
}
?>