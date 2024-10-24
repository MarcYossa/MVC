<?php
require_once '../config/database.php'; // Assurez-vous que le chemin est correct
require_once '../models/Reponse.php'; // Assurez-vous que le chemin est correct

class SuiviReclamation {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Lire toutes les réclamations
    public function lireReclamations() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM reclamation ORDER BY date_creation DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la lecture des réclamations : " . $e->getMessage());
        }
    }

    // Obtenir les détails d'une réclamation spécifique
    public function obtenirDetailReclamation($idReclamation) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM reclamation WHERE ID = ?");
            $stmt->execute([$idReclamation]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'obtention des détails de la réclamation : " . $e->getMessage());
        }
    }

    // Répondre à une réclamation
    public function repondreReclamation($idReclamation, $contenuReponse) {
        try {
            // Créer une instance de la classe Reponse
            $reponse = new Reponse();
            $idReponse = $reponse->ajouterReponse($contenuReponse);

            // Mettre à jour le statut de la réclamation à "traitée"
            $stmt = $this->pdo->prepare("UPDATE reclamation SET statut = 'traitée', date_reponse = NOW() WHERE id = ?");
            $stmt->execute([$idReclamation]);

            // Stocker les ID dans la table de liaison
            $this->associerReclamationEtReponse($idReclamation, $idReponse);

            return true; // Retourne vrai si tout s'est bien passé
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la réponse à la réclamation : " . $e->getMessage());
        }
    }

    // Associer une réclamation avec une réponse
    private function associerReclamationEtReponse($idReclamation, $idReponse) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO rclam_as_rpnse (id_reclamation, id_reponse) VALUES (?, ?)");
            $stmt->execute([$idReclamation, $idReponse]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'association réclamation-réponse : " . $e->getMessage());
        }
    }
}
?>