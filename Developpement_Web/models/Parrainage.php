<?php

class Parrainage {
    // Propriétés de la classe qui correspondent aux colonnes de la table Parrainage
    private $id_parrain;
    private $id_filleul;
    private $date_p;
    private $etat;
    private $pdo; // Instance de PDO pour la connexion à la base de données

    // Constructeur de la classe, prend un objet PDO en paramètre pour établir la connexion à la base de données
    public function __construct($pdo, $id_parrain, $id_filleul, $date_p = null, $etat) {
        $this->pdo = $pdo; // Stocker la connexion PDO
        $this->id_parrain = $id_parrain;
        $this->id_filleul = $id_filleul;
        $this->date_p = $date_p;
        $this->etat = $etat;
    }

    // Méthode pour gérer le parrainage
   
}
?>