<?php
require_once '../config/database.php'; // Assurez-vous que le chemin est correct

class SuiviReclamationsAdmin {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Lire toutes les réclamations
    public function lireReclamations() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM reclamation ORDER BY date_reclamation DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la lecture des réclamations : " . $e->getMessage());
        }
    }

    // Mettre à jour le statut d'une réclamation
    public function mettreAJourStatut($idReclamation, $nouveauStatut) {
        try {
            $stmt = $this->pdo->prepare("UPDATE reclamation SET statut = ? WHERE ID_reclamation = ?");
            $stmt->execute([$nouveauStatut, $idReclamation]);
            return true; // Retourne vrai si la mise à jour a réussi
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour du statut : " . $e->getMessage());
        }
    }

    // Supprimer une réclamation
    public function supprimerReclamation($idReclamation) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM reclamation WHERE ID_reclamation = ?");
            $stmt->execute([$idReclamation]);
            return true; // Retourne vrai si la suppression a réussi
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression de la réclamation : " . $e->getMessage());
        }
    }
}
?>