<?php
require_once '../config/database.php';

class ArticlePromotion {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Ajouter ou mettre à jour un article
    public function saveArticle($titre, $description, $prix, $prefix, $disponible = null, $prixPromo = null, $dateDebutPromo = null, $dateFinPromo = null) {
        // Vérification du préfixe
        if (!in_array($prefix, ['PLT', 'BOI'])) {
            throw new Exception("Le préfixe doit être PLT ou BOI.");
        }

        // Générer l'ID_Article
        $idArticle = $prefix . $this->generateUniqueId();

        try {
            $stmt = $this->pdo->prepare("INSERT INTO article (ID_Article, titre, description, prix, prix_promo, date_debut_promo, date_fin_promo, Disponible) 
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                                          ON DUPLICATE KEY UPDATE 
                                          titre = VALUES(titre),
                                          description = VALUES(description),
                                          prix = VALUES(prix),
                                          prix_promo = VALUES(prix_promo),
                                          date_debut_promo = VALUES(date_debut_promo),
                                          date_fin_promo = VALUES(date_fin_promo),
                                          Disponible = VALUES(Disponible)");
            $stmt->execute([$idArticle, $titre, $description, $prix, $prixPromo, $dateDebutPromo, $dateFinPromo, $disponible]);
            return $this->pdo->lastInsertId(); // ID auto-incrémenté
        } catch (PDOException $e) {
            echo "Erreur lors de l'enregistrement de l'article : " . $e->getMessage();
            return false;
        }
    }

    // Générer un ID unique basé sur l'auto-incrémentation
    private function generateUniqueId() {
        // Récupérer le dernier ID auto-incrémenté
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM article");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] + 1; // Commencer à 1
    }

    // Lire tous les articles
    public function readAll() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM article");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la lecture des articles : " . $e->getMessage());
        }
    }

    // Vérifier si un article est en promotion
    public function isArticleOnPromotion($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT prix_promo, date_debut_promo, date_fin_promo FROM article WHERE id = ?");
            $stmt->execute([$id]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($article) {
                $now = new DateTime();
                $debutPromo = new DateTime($article['date_debut_promo']);
                $finPromo = new DateTime($article['date_fin_promo']);
                
                return $article['prix_promo'] !== null && $now >= $debutPromo && $now <= $finPromo;
            }
            return false;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification de la promotion : " . $e->getMessage());
        }
    }

    // Obtenir le prix final de l'article
    public function getFinalPrice($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT prix, prix_promo FROM articles WHERE id = ?");
            $stmt->execute([$id]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($article) {
                return $this->isArticleOnPromotion($id) ? $article['prix_promo'] : $article['prix'];
            }
            return null; // Article non trouvé
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du prix : " . $e->getMessage());
        }
    }

    // Appliquer une promotion à un article
    public function applyPromotion($id, $discountPercentage, $dateDebutPromo = null, $dateFinPromo = null) {
        if ($discountPercentage < 0 || $discountPercentage > 100) {
            throw new Exception("Le pourcentage de remise doit être compris entre 0 et 100.");
        }

        $article = $this->readArticle($id);
        if (!$article) {
            throw new Exception("Article non trouvé.");
        }

        $currentPrice = $article['prix'];
        $newPrice = $currentPrice - ($currentPrice * ($discountPercentage / 100));

        if ($this->updatePrice($id, $newPrice, $dateDebutPromo, $dateFinPromo)) {
            return $newPrice;
        }
        throw new Exception("La mise à jour du prix a échoué.");
    }

    // Mettre à jour le prix d'un article
    private function updatePrice($id, $newPrice, $dateDebutPromo, $dateFinPromo) {
        try {
            $stmt = $this->pdo->prepare("UPDATE articles SET prix_promo = ?, date_debut_promo = ?, date_fin_promo = ? WHERE id = ?");
            return $stmt->execute([$newPrice, $dateDebutPromo, $dateFinPromo, $id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour du prix : " . $e->getMessage());
        }
    }

    // Lire un article par ID
    private function readArticle($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la lecture de l'article : " . $e->getMessage());
        }
    }
}
?>