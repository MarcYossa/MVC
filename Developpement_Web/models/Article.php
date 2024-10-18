<?php

class Article {
    // Propriétés de la classe qui correspondent aux colonnes de la table Article
    private $id_plat;
    private $nom_A;
    private $description_A;
    private $prix;
    private $disponible;
    private $pdo; // Instance de PDO pour la connexion à la base de données

    // Constructeur de la classe, prend un objet PDO en paramètre pour établir la connexion à la base de données
    public function __construct($pdo, $id_plat, $nom_A, $description_A, $prix, $disponible) {
        $this->pdo = $pdo; // Stocker la connexion PDO
        $this->id_plat = $id_plat;
        $this->nom_A = $nom_A;
        $this->description_A = $description_A;
        $this->prix = $prix;
        $this->disponible = $disponible;
    }

    // Méthode pour gérer les articles
    
}
?>