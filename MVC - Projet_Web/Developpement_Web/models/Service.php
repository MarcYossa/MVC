<?php

class Service {
    private $pdo;
    private $id_service;
    private $id_personne;
    private $type_s;
    private $statut_s;
    private $commentaire;

    public function __construct($pdo, $id_service, $id_personne, $type_s, $statut_s = 'en attente', $commentaire = '') {
        $this->pdo = $pdo;
        $this->id_service = $id_service;
        $this->id_personne = $id_personne;
        $this->type_s = $type_s;
        $this->statut_s = $statut_s;
        $this->commentaire = $commentaire;
    }

    

    // Accesseurs
    public function getIdService() {
        return $this->id_service;
    }

    public function getIdPersonne() {
        return $this->id_personne;
    }

    public function getTypeS() {
        return $this->type_s;
    }

    public function getStatutS() {
        return $this->statut_s;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }
}

?>