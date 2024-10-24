<?php

class Compte {
    // Propriétés de la classe qui correspondent aux colonnes de la table Compte
    private $id_compte;
    private $mot_de_passe;
    private $role;
    private $date_connexion;
    private $pdo; // Instance de PDO pour la connexion à la base de données

    // Constructeur de la classe, prend un objet PDO en paramètre pour établir la connexion à la base de données
    public function __construct($pdo, $id_compte, $mot_de_passe, $role, $date_connexion = null) {
        $this->pdo = $pdo; // Stocker la connexion PDO
        $this->id_compte = $id_compte;
        $this->mot_de_passe = $mot_de_passe;
        $this->role = $role;
        $this->date_connexion = $date_connexion;
    }

    // Méthode pour gérer les comptes
}
?>