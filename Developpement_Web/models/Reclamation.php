<?php
require_once '../config/database.php'; // Assurez-vous que le chemin est correct

class Reclamation {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Générer un nouvel ID de réclamation
    private function genererIdReclamation() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM reclamation");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nouveauId = 'RCL' . str_pad($result['count'] + 1, 4, '0', STR_PAD_LEFT);
        return $nouveauId;
    }

    // Ajouter une nouvelle réclamation
    public function ajouterReclamation($idUtilisateur, $idCommande, $description) {
        try {
            $idReclamation = $this->genererIdReclamation();
            $dateReclamation = date('Y-m-d H:i:s'); // Date actuelle
            $statut = 'en attente'; // Statut par défaut

            $stmt = $this->pdo->prepare("INSERT INTO reclamation (ID_reclamation, ID_Utilisateur, ID_commande, description, date_reclamation, statut) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$idReclamation, $idUtilisateur, $idCommande, $description, $dateReclamation, $statut]);

            return $idReclamation; // Retourne l'ID de la nouvelle réclamation
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de la réclamation : " . $e->getMessage());
        }
    }
}
?>