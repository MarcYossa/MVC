<?php

require_once '../includes/db.php'; // Chemin vers db.php
require_once __DIR__ . '/../Parrainage.php'; // Chemin vers Parrainage.php

class Inscription {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function inscrire($code_parrainage, $nom_u, $email, $tel, $status_compte, $mot_de_passe) {
        // Validation de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'email est invalide.");
        }

        // Vérification si l'email existe déjà dans la table Utilisateurs
        $stmtEmailCheck = $this->pdo->prepare("SELECT COUNT(*) FROM Utilisateurs WHERE Email = ?");
        $stmtEmailCheck->execute([$email]);
        if ($stmtEmailCheck->fetchColumn() > 0) {
            throw new Exception("L'email est déjà utilisé.");
        }

        // Initialiser l'ID du parrain à null
        $id_parrain = null;

        // Si un code de parrainage est fourni, récupérer l'ID du parrain
        if (!empty($code_parrainage)) {
            $id_parrain = $this->recupererIdParrainParCode($code_parrainage);
            if (!$id_parrain) {
                throw new Exception("Code de parrainage invalide.");
            }
        }

        // Démarrer une transaction
        $this->pdo->beginTransaction();

        try {
            // Hachage du mot de passe
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Générer un nouvel ID de compte avec le préfixe "Cpt"
            $id_compte = $this->generateUniqueId("Cpt");

            // Insérer un nouveau compte dans la table Compte
            $stmtCompte = $this->pdo->prepare("INSERT INTO Compte (ID_compte, Mot_de_passe, Role) VALUES (?, ?, ?)");
            $stmtCompte->execute([$id_compte, $hashed_password, 'client']);

            // Générer un nouvel ID utilisateur avec le préfixe "Ut"
            $id_utilisateur = $this->generateUniqueId("Ut");

            // Générer un code de parrainage pour l'utilisateur
            $code_utilisateur = $this->generateUniqueCode();

            // Insérer dans Utilisateurs
            $stmtUtilisateur = $this->pdo->prepare("INSERT INTO Utilisateurs (ID_utilisateur, ID_parrain, ID_compte, Nom_u, Email, Tel, Status_compte, Code_parrainage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtUtilisateur->execute([$id_utilisateur, $id_parrain, $id_compte, $nom_u, $email, $tel, $status_compte, $code_utilisateur]);

            // Enregistrer le parrainage dans la table Parrainage uniquement si un ID de parrain est fourni
            if ($id_parrain) {
                echo "ID du parrain : " . $id_parrain . ", ID du filleul : " . $id_utilisateur; // Debug
                $stmtParrainage = $this->pdo->prepare("INSERT INTO Parrainage (ID_parrain, ID_filleul, État) VALUES (?, ?, ?)");
                try {
                    $stmtParrainage->execute([$id_parrain, $id_utilisateur, 'Actif']);
                } catch (PDOException $e) {
                    echo "Erreur lors de l'insertion dans Parrainage : " . $e->getMessage(); // Debug
                }
            } else {
                echo "Aucun parrain, insertion de parrainage ignorée."; // Debug
            }

            // Valider la transaction
            $this->pdo->commit();
            return $id_utilisateur; // Retourner l'ID_utilisateur

        } catch (PDOException $e) {
            // Annuler la transaction en cas d'erreur
            $this->pdo->rollBack();
            throw new Exception("Erreur lors de l'inscription : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer l'ID du parrain à partir du code de parrainage
    private function recupererIdParrainParCode($code_parrainage) {
        $query = "SELECT ID_utilisateur FROM Utilisateurs WHERE Code_parrainage = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$code_parrainage]);
        return $stmt->fetchColumn(); // Retourne l'ID du parrain ou null s'il n'est pas trouvé
    }

    // Fonction pour générer un code de parrainage unique
    private function generateUniqueCode() {
        do {
            $code = strtoupper(substr(bin2hex(random_bytes(4)), 0, 6)); // Génère un code aléatoire de 6 caractères
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Utilisateurs WHERE Code_parrainage = ?");
            $stmt->execute([$code]);
            $exists = $stmt->fetchColumn() > 0;
        } while ($exists);
        return $code;
    }

    // Fonction pour générer un ID unique avec un préfixe
    private function generateId($prefix) {
        $number = rand(1000000, 9999999); // Génère un nombre entre 1000000 et 9999999
        return $prefix . $number; // Retourne le préfixe suivi du nombre
    }

    // Fonction pour générer un ID unique en vérifiant l'unicité
    private function generateUniqueId($prefix) {
        do {
            $id = $this->generateId($prefix);
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Utilisateurs WHERE ID_utilisateur = ? UNION SELECT COUNT(*) FROM Compte WHERE ID_compte = ?");
            $stmt->execute([$id, $id]);
            $exists = $stmt->fetchColumn() > 0;
        } while ($exists);
        return $id;
    }
}

?>