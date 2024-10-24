<?php
// models/Suppression.php

require_once '../config/database.php';

class Suppression {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Fonction qui supprimes un article 
    public function supprimerArticle($id_plat) {
        // Supprimer l'article dans la base de données
        $stmt = $this->pdo->prepare("DELETE FROM Article WHERE ID_plat = ?");
        $stmt->execute([$id_plat]);

        return true; // Retourner vrai si la suppression a réussi
    }
}
?>