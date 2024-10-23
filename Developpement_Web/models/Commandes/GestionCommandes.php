<?php
require_once '../config/database.php'; // Assurez-vous que le chemin est correct

class GestionCommandesEmploye {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Authentifier l'employé
    public function authentifier($username, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM employes WHERE username = ? AND password = ?");
            $stmt->execute([$username, md5($password)]); // Utilisation de md5 pour le hachage
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'authentification : " . $e->getMessage());
        }
    }

    // Lire toutes les commandes
    public function lireCommandes() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM commandes WHERE statut = 'en attente' ORDER BY date_commande DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la lecture des commandes : " . $e->getMessage());
        }
    }

    // Préparer une commande
    public function preparerCommande($idCommande) {
        try {
            $stmt = $this->pdo->prepare("UPDATE commandes SET statut = 'en préparation' WHERE ID_commande = ?");
            $stmt->execute([$idCommande]);
            return true; // Retourne vrai si la préparation a réussi
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la préparation de la commande : " . $e->getMessage());
        }
    }

    // Valider une commande
    public function validerCommande($idCommande) {
        try {
            $stmt = $this->pdo->prepare("UPDATE commandes SET statut = 'validée' WHERE ID_commande = ?");
            $stmt->execute([$idCommande]);
            return true; // Retourne vrai si la validation a réussi
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la validation de la commande : " . $e->getMessage());
        }
    }
}
?>