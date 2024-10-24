<?php

class Commande {
    private $pdo;
    private $id_commande;
    private $id_utilisateur;
    private $montant;
    private $pt_accumule;

    public function __construct($pdo, $id_commande, $id_utilisateur, $montant = 0, $pt_accumule = 0) {
        $this->pdo = $pdo;
        $this->id_commande = $id_commande;
        $this->id_utilisateur = $id_utilisateur;
        $this->montant = $montant;
        $this->pt_accumule = $pt_accumule;
    }

    public function __toString() {
        return "Commande ID: {$this->id_commande}, Utilisateur: {$this->id_utilisateur}, Montant: {$this->montant}, Points: {$this->pt_accumule}";
    }

    // Accesseurs
    public function getIdCommande() {
        return $this->id_commande;
    }

    public function getIdUtilisateur() {
        return $this->id_utilisateur;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function getPtAccumule() {
        return $this->pt_accumule;
    }
}

?>