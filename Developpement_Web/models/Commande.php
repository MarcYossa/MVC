<?php

class Commande {
    // Propriétés de la classe qui correspondent aux colonnes de la table Commandes
    private $id_commande;
    private $id_utilisateur;
    private $id_plat;
    private $date_commande;
    private $pdo; // Instance de PDO pour la connexion à la base de données

    // Constructeur de la classe, prend un objet PDO en paramètre pour établir la connexion à la base de données
    public function __construct($pdo, $id_commande, $id_utilisateur, $id_plat, $date_commande = null) {
        $this->pdo = $pdo; // Stocker la connexion PDO
        $this->id_commande = $id_commande;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_plat = $id_plat;
        $this->date_commande = $date_commande;
    }

    // Méthode pour gérer les commandes
       
}
?>