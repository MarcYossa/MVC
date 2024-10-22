<?php
require_once '../config/database.php';

class Reclamation {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Créer une nouvelle réclamation
    public function create($studentId, $subject, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO Reclamations (student_id, subject, message, status) VALUES (?, ?, ?, 'En attente')");
        return $stmt->execute([$studentId, $subject, $message]);
    }

    // Lire toutes les réclamations
    public function readAll() {
        $stmt = $this->pdo->query("SELECT * FROM Reclamations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lire une réclamation par ID
    public function read($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Reclamations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour le statut d'une réclamation
    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE Reclamations SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // Supprimer une réclamation
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Reclamations WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Méthode pour récupérer les réponses à une réclamation
public function getResponses($id) {
    $stmt = $this->pdo->prepare("SELECT r.ID_Reponse, r.Date_R, r.Description 
                                  FROM Reponse r 
                                  JOIN reclam_as_rpnse rr ON r.ID_Reponse = rr.ID_Reponse 
                                  WHERE rr.ID_reclamation = ?");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>