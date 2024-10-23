<?php
// models/Creation.php

require_once '../config/database.php';

class Creation {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function ajouterArticle($id_article, $titre, $description, $prix, $disponible) {
        // Vérifier que l'ID_Article a exactement 10 caractères et commence par "PLT" ou "BOI"
        if (!preg_match('/^(PLT|BOI)\d{7}$/', $id_article)) {
            throw new Exception("L'ID_Article doit commencer par 'PLT' ou 'BOI', suivi de 7 chiffres, pour un total de 10 caractères.");
        }

        // Vérifier que l'ID_Article est unique
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM articles WHERE ID_Article = ?");
        $stmt->execute([$id_article]);
        
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("Un article avec cet ID existe déjà.");
        }

        // Insertion dans la base de données
        $stmt = $this->pdo->prepare("INSERT INTO article (ID_Article, titre, description, prix, Disponible) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_article, $titre, $description, $prix, $disponible]);

        return true; // Retourner vrai si l'ajout a réussi
    }
}
?>