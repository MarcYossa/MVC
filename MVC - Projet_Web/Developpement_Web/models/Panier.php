<?php
class Panier {
    private $pdo;
    private $id_panier;
    private $id_utilisateur;
    private $total_article; // Propriété pour le total d'articles

    public function __construct($pdo, $id_panier, $id_utilisateur, $total_article = 0) {
        $this->pdo = $pdo;
        $this->id_panier = $id_panier;
        $this->id_utilisateur = $id_utilisateur;
        $this->total_article = $total_article; // Initialiser avec la valeur passée
    }

    public function loadTotal() {
        $stmt = $this->pdo->prepare("SELECT Total_article FROM Panier WHERE ID_panier = ?");
        $stmt->execute([$this->id_panier]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Corriger le nom de la propriété
        $this->total_article = $result['Total_article'] ?? 0; // Gérer les valeurs nulles
    }

    public function updateTotal($total_article) {
        $stmt = $this->pdo->prepare("UPDATE Panier SET Total_article = ? WHERE ID_panier = ?");
        $stmt->execute([$total_article, $this->id_panier]);
        $this->total_article = $total_article; // Mettre à jour la propriété locale
    }

    public function getTotalArticle() {
        return $this->total_article; // Utiliser le nom correct
    }

    public function create() {
        $stmt = $this->pdo->prepare("INSERT INTO Panier (ID_panier, ID_utilisateur, Total_article) VALUES (?, ?, ?)");
        $stmt->execute([$this->id_panier, $this->id_utilisateur, $this->total_article]);
    }
}
?>