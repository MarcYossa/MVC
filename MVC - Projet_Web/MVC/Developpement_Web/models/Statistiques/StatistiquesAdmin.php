<?php
require_once '../config/database.php'; // Assurez-vous que le chemin est correct

class StatistiquesAdmin {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Obtenir le total des ventes
    public function obtenirTotalVentes() {
        try {
            $stmt = $this->pdo->query("SELECT SUM(montant) AS total_ventes FROM ventes");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_ventes'] ?: 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du total des ventes : " . $e->getMessage());
        }
    }

    // Obtenir le nombre total de commandes
    public function obtenirTotalCommandes() {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) AS total_commandes FROM commandes");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_commandes'] ?: 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du total des commandes : " . $e->getMessage());
        }
    }

    // Obtenir les statistiques d'utilisation des programmes de fidélité
    public function obtenirStatistiquesFidelite() {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) AS total_fidelite FROM fidelites");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_fidelite'] ?: 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des statistiques de fidélité : " . $e->getMessage());
        }
    }

    // Obtenir les statistiques d'utilisation des programmes de parrainage
    public function obtenirStatistiquesParrainage() {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) AS total_parrainages FROM parrainages");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_parrainages'] ?: 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des statistiques de parrainage : " . $e->getMessage());
        }
    }
}
?>