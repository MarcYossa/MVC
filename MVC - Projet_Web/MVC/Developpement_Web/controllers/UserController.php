<?php
// controllers/UserController.php

require_once '../models/User/Inscription.php';
require_once '../models/User/Connexion.php';

class UserController {
    private $inscriptionModel;
    private $connexionModel;

    public function __construct() {
        $this->inscriptionModel = new Inscription();
        $this->connexionModel = new Connexion();
    }

    public function inscription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id_utilisateur = $_POST['id_utilisateur'];
                $id_parrain = $_POST['id_parrain'] ?: null;
                $code_parrainage = $_POST['code_parrainage'] ?: null;
                $nom_u = $_POST['nom_u'];
                $email = $_POST['email'];
                $tel = $_POST['tel'];
                $status_compte = $_POST['status_compte'];
                $mot_de_passe = $_POST['mot_de_passe'];

                // Validation du mot de passe
            if (!$this->validatePassword($mot_de_passe)) {
                throw new Exception("Le mot de passe doit contenir au moins une lettre majuscule et deux lettres.");
            }

                $id_compte = $this->inscriptionModel->inscrire($id_utilisateur, $id_parrain, $code_parrainage, $nom_u, $email, $tel, $status_compte, $mot_de_passe);
                echo "Inscription réussie ! Votre ID de compte est : " . $id_compte;
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            echo "Méthode de requête non supportée.";
        }
    }

    // Fonction de connexion
    public function connexion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = $_POST['email'];
                $mot_de_passe = $_POST['mot_de_passe'];

                $id_compte = $this->connexionModel->connecter($email, $mot_de_passe);
                $_SESSION['user_id'] = $id_compte;

                // Redirection en fonction de l'ID_compte
                if (strpos($id_compte, 'CLI') === 0) {
                    header("Location: /views/client_dashboard.php");
                } elseif (strpos($id_compte, 'ADM') === 0) {
                    header("Location: /views/admin_dashboard.php");
                } elseif (strpos($id_compte, 'VEN') === 0) {
                    header("Location: /views/vendor_dashboard.php");
                } else {
                    header("Location: /views/default_dashboard.php");
                }
                exit();
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            echo "Méthode de requête non supportée.";
        }
    }

    // Fonction de mise à jour de mot de passe
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = $_POST['email'];
                $new_password = $_POST['new_password'];

                // Validation du mot de passe
            if (!$this->validatePassword($new_password)) {
                throw new Exception("Le mot de passe doit contenir au moins une lettre majuscule et deux lettres.");
            }

                // Mettre à jour le mot de passe dans la base de données
                $stmt = $this->connexionModel->updatePassword($email, $new_password); // Ajoutez cette méthode au modèle
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

    // Méthode de déconnexion 
    public function logout() {
        $this->connexionModel->deconnexion();
        // Démarrer la session pour stocker le message
        session_start();
        $_SESSION['success'] = "Déconnexion réussie !";

        header("Location: /views/Login.php"); // Rediriger vers la page de connexion
        exit();
    }

        // Méthode de validation du mot de passe
        private function validatePassword($password) {
            return preg_match('/^(?=.*[A-Z])(?=.*[a-z].*[a-z]).{6,}$/', $password);
        }
    }
?>