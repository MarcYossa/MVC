<?php
// models/Connexion.php

require_once '../config/database.php';

class Connexion {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection(); // Assurez-vous que votre classe Database est bien définie
    }

    public function connecter($email, $mot_de_passe) {
        $stmt = $this->pdo->prepare("SELECT mot_de_passe, ID_compte FROM Compte WHERE email = ?");
        $stmt->execute([$email]);
        $compte = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($compte && password_verify($mot_de_passe, $compte['mot_de_passe'])) {
            echo'Connexion réussie';
            return $compte['ID_compte']; // Retourner l'ID_compte
        } else {
            throw new Exception("Email ou mot de passe incorrect.");
        }
    }

        // Foncion de mise à jour du mot de passe d'un utilisateur
        public function updatePassword($email, $new_password) {
            // Hachage du nouveau mot de passe
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Mise à jour du mot de passe dans la base de données
            $stmt = $this->pdo->prepare("UPDATE Compte SET mot_de_passe = ? WHERE email = ?");
            $stmt->execute([$hashed_password, $email]);
            
            return true; // Retourner vrai si la mise à jour a réussi
        }

        // Fonction de déconnexion d'un utilisateur
        public function deconnexion() {
            session_start();
            // Détruire toutes les variables de session
            $_SESSION = [];
            
            // Si vous voulez détruire la session complètement
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            
            // Détruire la session
            session_destroy();
        }

}

?>