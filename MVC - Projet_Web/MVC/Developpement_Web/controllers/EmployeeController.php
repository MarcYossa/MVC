<?php
// controllers/EmployeController.php

require_once '../models/Compte_Employee/Ajout.php';
require_once '../models/Compte_Employee/Modify.php';
require_once '../models/Compte_Employee/Suppression.php';

class EmployeController {
    private $ajoutModel;
    private $modifyModel;
    private $suppressModel;

    public function __construct() {
        $this->ajoutModel = new Ajout();
        $this->modifyModel = new Modify();
        $this->suppressModel = new Suppression();

    }

    public function showAddEmploye() {
        require_once '../views/AddEmploye.php'; // Afficher le formulaire d'ajout
    }

    public function addEmploye() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = $_POST['email'];
                $mot_de_passe = $_POST['mot_de_passe'];

                // Validation du mot de passe
            if (!$this->validatePasswordEmp($mot_de_passe)) {
                throw new Exception("Le mot de passe doit contenir au moins une lettre majuscule et deux lettres.");
            }

                $this->ajoutModel->ajouterEmploye( $email, $mot_de_passe);
                echo "L'employé a été ajouté avec succès !";
            } catch (Exception $e) {
                session_start();
                $_SESSION['error'] = $e->getMessage();
                header("Location: /views/AddEmploye.php");
                exit();
            }
        } else {
            echo "Méthode de requête non supportée.";
        }
    }

    // Fonction de mise à jour de mot de passe
    public function resetPasswordEMP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = $_POST['email'];
                $new_password = $_POST['new_password'];

                // Validation du mot de passe
            if (!$this->validatePasswordEMP($new_password)) {
                throw new Exception("Le mot de passe doit contenir au moins une lettre majuscule et deux lettres.");
            }

                // Mettre à jour le mot de passe dans la base de données
                $stmt = $this->modifyModel->updatePasswordEMP($email, $new_password); // Ajoutez cette méthode au modèle
                echo "Votre mot de passe a été réinitialisé avec succès.";
            } catch (Exception $e) {
                session_start();
                $_SESSION['error'] = $e->getMessage();
                echo'Echec de la mise à jour.';
                exit();
            }
        } else {
            echo "Méthode de requête non supportée.";
        }
    }

        // Méthode de suppression de compte d'employés
    public function deleteEmploye() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id_compte = $_POST['id_compte'];

                $this->suppressModel->supprimerEmploye($id_compte);
                echo "L'employé a été supprimé avec succès !";
            } catch (Exception $e) {
                session_start();
                $_SESSION['error'] = $e->getMessage();
                header("Location: /views/DeleteEmploye.php");
                exit();
            }
        } else {
            echo "Méthode de requête non supportée.";
        }
    }
        
    // Fonction de validation de mot de passe
    private function validatePasswordEmp($password) {
        return preg_match('/^(?=.*[A-Z])(?=.*[a-z].*[a-z]).{6,}$/', $password);
    }
}
?>