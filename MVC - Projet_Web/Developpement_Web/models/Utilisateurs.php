<?php

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
    }

    // Méthode pour gérer un utilisateur

}
?>