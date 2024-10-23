<?php
require_once '../models/Reclamation.php';
require_once '../models/Article/Reponse.php';

class ReclamationController {
    private $reclamationModel;
    private $reponseModel;

    public function __construct() {
        $this->reclamationModel = new Reclamation();
        $this->reponseModel = new Reponse();
    }

    // Créer une nouvelle réclamation
    public function createReclamation($studentId, $subject, $message) {
        return $this->reclamationModel->create($studentId, $subject, $message);
    }

    // Obtenir toutes les réclamations
    public function getAllReclamations() {
        return $this->reclamationModel->readAll();
    }

    // Obtenir une réclamation par ID
    public function getReclamation($id) {
        return $this->reclamationModel->read($id);
    }

    // Mettre à jour le statut d'une réclamation
    public function updateReclamationStatus($id, $status) {
        return $this->reclamationModel->updateStatus($id, $status);
    }

    // Supprimer une réclamation
    public function deleteReclamation($id) {
        return $this->reclamationModel->delete($id);
    }

    // Méthode de création de réponse à une réclamation
    public function createResponse($description, $reclamationId) {
        return $this->reponseModel->create($description, $reclamationId);
    }
}
?>