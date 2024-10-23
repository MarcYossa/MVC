<?php
require_once '../config/database.php'; // Assurez-vous que le chemin est correct

class Reponse {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Générer un nouvel ID de réponse
    private function genererIdReponse() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM reponses");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nouveauId = 'RP' . str_pad($result['count'] + 1, 4, '0', STR_PAD_LEFT);
        return $nouveauId;
    }

    // Ajouter une réponse
    public function ajouterReponse($contenuReponse) {
        try {
            $idReponse = $this->genererIdReponse();
            $stmt = $this->pdo->prepare("INSERT INTO reponses (id_reponse, contenu, date_creation) VALUES (?, ?, NOW())");
            $stmt->execute([$idReponse, $contenuReponse]);
            return $idReponse; // Retourne l'ID de la nouvelle réponse
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de la réponse : " . $e->getMessage());
        }
    }
}
?>