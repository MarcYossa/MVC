<?php
require_once '../config/database.php'; // Assurez-vous que le chemin est correct

class GestionReclamations {
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

    // Valider une réponse
    public function validerReponse($idReclamation, $idReponse) {
        try {
            // Mettre à jour le statut de la réclamation
            $stmt = $this->pdo->prepare("UPDATE reclamation SET statut = 'validée' WHERE ID_reclamation = ?");
            $stmt->execute([$idReclamation]);

            // Mettre à jour la réponse associée (si nécessaire)
            // Ici vous pourriez mettre à jour un statut de réponse, par exemple
            $stmtReponse = $this->pdo->prepare("UPDATE reponse SET statut = 'validée' WHERE id_reponse = ?");
            $stmtReponse->execute([$idReponse]);

            return true; // Retourne vrai si la validation a réussi
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la validation de la réponse : " . $e->getMessage());
        }
    }

    // Rejeter une réponse
    public function rejeterReponse($idReclamation, $idReponse) {
        try {
            // Mettre à jour le statut de la réclamation
            $stmt = $this->pdo->prepare("UPDATE reclamation SET statut = 'rejetée' WHERE ID_reclamation = ?");
            $stmt->execute([$idReclamation]);

            // Mettre à jour la réponse associée (si nécessaire)
            $stmtReponse = $this->pdo->prepare("UPDATE reponse SET statut = 'rejetée' WHERE id_reponse = ?");
            $stmtReponse->execute([$idReponse]);

            return true; // Retourne vrai si le rejet a réussi
        } catch (Exception $e) {
            throw new Exception("Erreur lors du rejet de la réponse : " . $e->getMessage());
        }
    }
}
?>