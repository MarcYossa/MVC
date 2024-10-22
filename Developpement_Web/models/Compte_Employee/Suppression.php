<?php
// models/Employee/Suppression.php

require_once '../config/database.php';

class Suppression{
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection(); // Assurez-vous que votre classe Database est bien définie
    }

    // Fonction de suppression de compte employe
    public function supprimerEmploye($id_compte) {
        
         // Vérifier que l'ID_compte commence par "EMP"
         if (strpos($id_compte, 'EMP') !== 0) {
            throw new Exception("L'ID du compte doit commencer par 'EMP'.");
        }
        // Vérifier si l'ID_compte existe
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Compte WHERE ID_compte = ?");
        $stmt->execute([$id_compte]);
        
        if ($stmt->fetchColumn() == 0) {
            throw new Exception("Aucun employé trouvé avec cet ID.");
        }

        // Supprimer le compte employé
        $stmt = $this->pdo->prepare("DELETE FROM Compte WHERE ID_compte = ?");
        $stmt->execute([$id_compte]);

        return true; // Retourner vrai si la suppression a réussi
    }
}