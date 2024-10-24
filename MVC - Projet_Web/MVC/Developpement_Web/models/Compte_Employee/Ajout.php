<?php
// models/Employee/Ajout.php

require_once '../config/database.php';

class Ajout{
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection(); // Assurez-vous que votre classe Database est bien définie
    }

    public function ajouterEmploye($email, $mot_de_passe) {

        // Validation de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'email est invalide.");
        }

        // Vérification si l'email existe déjà
        $stmtEmailCheck = $this->pdo->prepare("SELECT COUNT(*) FROM Compte WHERE email = ?");
        $stmtEmailCheck->execute([$email]);
        if ($stmtEmailCheck->fetchColumn() > 0) {
            throw new Exception("L'email est déjà utilisé.");
        }

        // Commencer une transaction
        $this->pdo->beginTransaction();

        try {
            // Hachage du mot de passe
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Insérer les données pour obtenir l'ID auto-incrémenté
            $stmt = $this->pdo->prepare("INSERT INTO Compte (role, email, mot_de_passe) VALUES ('employé', ?, ?, ?)");
            $stmt->execute(['Employé', $email, $hashed_password]);
            
            // Récupérer l'ID de la dernière insertion
            $id_auto = $this->pdo->lastInsertId();

            // Générer l'ID_compte
            $id_compte = 'EMP' . str_pad($id_auto, 5, '0', STR_PAD_LEFT);

            // Mettre à jour l'ID_compte dans la base de données
            $stmt = $this->pdo->prepare("UPDATE Compte SET ID_compte = ? WHERE id_auto = ?");
            $stmt->execute([$id_compte, $id_auto]);

            // Commit la transaction
            $this->pdo->commit();
            return true; // Retourner vrai si l'ajout a réussi
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de l'ajout de l'employé : " . $e->getMessage());
        }
    }

    // Lire tous les comptes employés
    public function lireTousLesComptesEmployes() {
        try {
            $stmt = $this->pdo->query("SELECT ID_compte, email, role FROM Compte WHERE role = 'employé' ORDER BY email");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la lecture des comptes employés : " . $e->getMessage());
        }
    }
}
?>