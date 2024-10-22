<?php
// models/Modify.php

require_once '../config/database.php';

class Modify {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Fonction de modification d'un article
    public function modifierArticle($id_plat, $nom_m, $description_m, $prix, $disponible) {
        // Mettre à jour l'article dans la base de données
        $stmt = $this->pdo->prepare("UPDATE Article SET nom_m = ?, description_m = ?, Prix = ?, Disponible = ? WHERE ID_plat = ?");
        $stmt->execute([$nom_m, $description_m, $prix, $disponible, $id_plat]);

        return true; // Retourner vrai si la mise à jour a réussi
    }

    // Fonction d'affichage d'un article précis
    public function obtenirArticle($id_plat) {
        // Obtenir un article par son ID_PLAT
        $stmt = $this->pdo->prepare("SELECT * FROM Article WHERE ID_plat = ?");
        $stmt->execute([$id_plat]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}