<?php
require_once '../config/database.php';

class Jeu {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Fonction qui génère l'ID automatiquement
    private function generateIdJeu() {
        // Récupérer le dernier ID de jeu
        $stmt = $this->pdo->query("SELECT Id_jeu FROM jeu ORDER BY Id_jeu DESC LIMIT 1");
        $dernierId = $stmt->fetchColumn();

        if ($dernierId) {
            // Extraire le nombre et incrémenter
            $prefix = substr($dernierId, 0, 3); // Les trois premières lettres
            $numero = (int)substr($dernierId, 3); // Les deux derniers chiffres
            $numero++;
            // Formater le nouvel ID
            return $prefix . str_pad($numero, 2, '0', STR_PAD_LEFT);
        } else {
            // Si aucun ID n'existe, commencer par A01
            return 'A01';
        }
    }

    // Créer un nouveau jeu
    public function ajouterJeu($image) {
        $idJeu = $this->generateIdJeu();

        $stmt = $this->pdo->prepare("INSERT INTO jeu (Id_jeu, Titre_j, Description, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$idJeu, $image]);

        return $idJeu; // Retourner le nouvel ID
    }


    // Lire tous les jeux
    public function readAll() {
        $stmt = $this->pdo->query("SELECT * FROM Jeux");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>