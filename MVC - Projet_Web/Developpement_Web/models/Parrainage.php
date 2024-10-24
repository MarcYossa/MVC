<?php

class Parrainage {
    // Propriétés de la classe qui correspondent aux colonnes de la table Parrainage
    private $pdo;
    private $id_parrain;
    private $id_filleul;
    private $date_p;
    private $etat;
     // Instance de PDO pour la connexion à la base de données

    // Constructeur de la classe, prend un objet PDO en paramètre pour établir la connexion à la base de données
    public function __construct($pdo, $id_parrain, $id_filleul, $date_p = null, $etat) {
        $this->pdo = $pdo; // Stocker la connexion PDO
        $this->id_parrain = $id_parrain;
        $this->id_filleul = $id_filleul;
        $this->date_p = $date_p ?? date('Y-m-d H:i:s'); // Date par défaut
        $this->etat = $etat;
    }


      // Méthode pour enregistrer le parrainage dans la base de données
      public function enregistrer() {
        $query = "INSERT INTO Parrainage (ID_parrain, ID_filleul, Date_p, État) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$this->id_parrain, $this->id_filleul, $this->date_p, $this->etat]);
    }
    public function getIdParrain() { return $this->id_parrain; }
    public function getIdFilleul() { return $this->id_filleul; }
}
    // Méthode pour gérer le parrainage
   

?>