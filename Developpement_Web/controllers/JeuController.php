<?php

require_once '../models/Jeu.php'; // Assurez-vous que le chemin est correct
require_once '../config/database.php'; // Pour la connexion PDO

class JeuController {
    private $jeuModel;

    public function __construct() {
        $pdo = Database::getConnection(); // Obtenir la connexion à la base de données
        $this->jeuModel = new Jeu($pdo);
    }

    // Méthode pour afficher le formulaire d'ajout d'un jeu
    public function afficherFormulaireAjout() {
        // Ici, vous pouvez inclure un fichier de vue ou afficher la logique HTML pour le formulaire
        echo '<form method="POST" action="JeuController.php?action=ajouter">
                <label for="image">Image URL:</label>
                <input type="text" name="image" required>
                <input type="submit" value="Ajouter">
              </form>';
    }

    // Méthode pour ajouter un jeu
    public function ajouterJeu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image = $_POST['image'];

            try {
                $idJeu = $this->jeuModel->ajouterJeu($image);
                echo "Jeu ajouté avec succès ! ID du jeu : $idJeu";
            } catch (Exception $e) {
                echo "Erreur lors de l'ajout du jeu : " . $e->getMessage();
            }
        } else {
            echo "Méthode non autorisée.";
        }
    }
}

// Gestion des actions
$action = isset($_GET['action']) ? $_GET['action'] : '';

$jeuController = new JeuController();

if ($action === 'ajouter') {
    $jeuController->ajouterJeu();
} else {
    $jeuController->afficherFormulaireAjout();
}
?>