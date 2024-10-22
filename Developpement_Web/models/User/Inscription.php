<?php
// models/Inscription.php

require_once '../config/database.php';

class Inscription {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection(); // Assurez-vous que votre classe Database est bien définie
    }

    public function inscrire($id_utilisateur, $id_parrain, $code_parrainage, $nom_u, $email, $tel, $status_compte, $mot_de_passe) {
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

        // Démarrer une transaction
        $this->pdo->beginTransaction();
        try {
            // Hachage du mot de passe
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            
            // Insérer un nouveau compte
            $stmtCompte = $this->pdo->prepare("INSERT INTO Compte (role, mot_de_passe, email) VALUES (?, ?, ?)");
            $stmtCompte->execute(['client', $hashed_password, $email]);
            $id_auto = $this->pdo->lastInsertId();

            // Générer l'ID_compte
            $prefix = 'CLI';
            $id_compte = $prefix . str_pad($id_auto, 5, '0', STR_PAD_LEFT);

            // Mettre à jour l'ID_compte dans la table Compte
            $updateStmt = $this->pdo->prepare("UPDATE Compte SET ID_compte = ? WHERE id_auto = ?");
            $updateStmt->execute([$id_compte, $id_auto]);

            // Insérer dans Utilisateurs
            $stmtUtilisateur = $this->pdo->prepare("INSERT INTO Utilisateurs (ID_utilisateur, ID_parrain, ID_compte, Code_parrainage, Nom_u, Email, Tel, Status_compte) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtUtilisateur->execute([$id_utilisateur, $id_parrain, $id_compte, $code_parrainage, $nom_u, $email, $tel, $status_compte]);

            // Valider la transaction
            $this->pdo->commit();
            return $id_compte; // Retourner l'ID_compte
        } catch (PDOException $e) {
            // Annuler la transaction en cas d'erreur
            $this->pdo->rollBack();
            throw $e; // Propager l'exception pour le gestionnaire d'erreurs
        }
    }
}
?>