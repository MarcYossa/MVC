<?php
// models/Employee/Modify.php

require_once '../config/database.php';

class Modify{
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection(); // Assurez-vous que votre classe Database est bien définie
    }

    // Fonction de modification du mot de passe du compte d'employé
    public function updatePasswordEmp($email, $new_password) {
        // Hachage du nouveau mot de passe
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Mise à jour du mot de passe dans la base de données
        $stmt = $this->pdo->prepare("UPDATE Compte SET mot_de_passe = ? WHERE email = ?");
        $stmt->execute([$hashed_password, $email]);
        
        return true; // Retourner vrai si la mise à jour a réussi
    }
}
?>