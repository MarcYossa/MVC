<?php
require_once '../config/database.php';

class Jeu {
    private $pdo;
    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Fonction qui génère l'ID automatiquement
    private function generateIdJeu() {
        $stmt = $this->pdo->query("SELECT Id_jeux FROM jeux ORDER BY Id_jeux DESC LIMIT 1");
        $dernierId = $stmt->fetchColumn();

        if ($dernierId) {
            $prefix = substr($dernierId, 0, 3); // Les trois premières lettres
            $numero = (int)substr($dernierId, 3); // Les chiffres après le préfixe
            $numero++;
            return $prefix . str_pad($numero, 2, '0', STR_PAD_LEFT);
        } else {
            return 'A01'; // Si aucun ID n'existe, commencer par A01
        }
    }

    // Créer un nouveau jeu
    public function ajouterJeu($titre, $description, $image) {
        $idJeu = $this->generateIdJeu();
        
        try {
            // Préparer la requête
            $stmt = $this->pdo->prepare("INSERT INTO jeux (ID_Jeux, ID_Utilisateur, titre_j, description, image) VALUES (?, NULL, ?, ?, ?)");
            
            // Exécutez la requête
            $stmt->execute([$idJeu, $titre, $description, $image]);
            return $this->pdo->lastInsertId(); // Retourne l'ID du dernier enregistrement
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion : " . $e->getMessage();
        }
    }

    // Lire tous les jeux
    public function readAll() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM jeux");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer l'erreur ici
            throw new Exception("Erreur lors de la lecture des jeux : " . $e->getMessage());
        }
    }
}
?>