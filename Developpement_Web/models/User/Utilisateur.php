<?php

require_once 'Registration.php'; // Appel de la claase Registration.php
require_once 'Login.php'; // Appel de la classe Login.php
require_once 'Session.php'; // Appel de la classe Session.php

class Utilisateur {
    // Propriétés de la classe qui correspondent aux colonnes de la table Utilisateurs
    private $id_utilisateur;
    private $id_parrain;
    private $id_compte;
    private $code_parrainage;
    private $nom_u;
    private $email;
    private $tel;
    private $point_fidelite;
    private $date_inscription;
    private $status_compte;
    private $pdo; // Instance de PDO pour la connexion à la base de données
    // Définition de variables pour pouvoir instancier les objets registration et login
    private $registration; 
    private $login;

    // Constructeur de la classe, prend un objet PDO en paramètre pour établir la connexion à la base de données
    public function __construct($pdo, $id_utilisateur, $id_parrain, $id_compte, $code_parrainage, $nom_u, $email, $tel, $point_fidelite = 0, $date_inscription = null, $status_compte) {
        $this->pdo = $pdo; // Utiliser pour stocker la PDO
        $this->id_utilisateur = $id_utilisateur;
        $this->id_parrain = $id_parrain;
        $this->id_compte = $id_compte;
        $this->code_parrainage = $code_parrainage;
        $this->nom_u = $nom_u;
        $this->email = $email;
        $this->tel = $tel;
        $this->point_fidelite = $point_fidelite;
        $this->date_inscription = $date_inscription;
        $this->status_compte = $status_compte;
        // Instanciation des objets Registration et login
        $this->registration = new Registration($pdo);
        $this->login = new Login($pdo);
    }

    // Méthode pour gérer un utilisateur
    
// Méthode d'inscription de l'utilisateur
     public function register($id_utilisateur, $id_parrain, $id_compte, $code_parrainage, $nom_u, $email, $tel, $mot_de_passe, $status_compte) {
        return $this->registration->registerUser($id_utilisateur, $id_parrain, $id_compte, $code_parrainage, $nom_u, $email, $tel, $mot_de_passe, $status_compte);
    }

     // Méthode de connexion
    public function login($email, $mot_de_passe) {
        return $this->login->loginUser($email, $mot_de_passe);
    }
    
    // Méthode pour vérifier si l'utilisateur est connecté
    public function isLoggedIn() {
        return Session::isLoggedInUser();
    }

    // Méthode pour se déconnecter
    public function logout() {
        Session::logoutUser();
    }
}
?>