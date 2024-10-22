<?php
// models/Creation.php

require_once '../config/database.php';

class Creation {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function ajouterArticle($id_plat, $nom_m, $description_m, $prix, $disponible) {
        // Vérifier que l'ID_PLAT a exactement 8 caractères et commence par "PLT" ou "BOI"
        if (!preg_match('/^(PLT|BOI)\d{5}$/', $id_plat)) {
            throw new Exception("L'ID_PLAT doit commencer par 'PLT' ou 'BOI', suivi de 5 chiffres, pour un total de 8 caractères.");
        }

        // Vérifier que l'ID_plat est unique
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Article WHERE ID_plat = ?");
        $stmt->execute([$id_plat]);
        
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("Un article avec cet ID existe déjà.");
        }

        // Insertion dans la base de données
        $stmt = $this->pdo->prepare("INSERT INTO Article (ID_plat, nom_m, description_m, Prix, Disponible) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_plat, $nom_m, $description_m, $prix, $disponible]);

        return true; // Retourner vrai si l'ajout a réussi
    }
}
?>