<?php
require_once '../models/Jeu.php';

class JeuController {
    private $jeuModel;

    public function __construct() {
        $this->jeuModel = new Jeu();
    }

    // Méthode pour afficher tous les jeux
    public function getAllJeux() {
        try {
            $jeux = $this->jeuModel->readAll();
            header('Content-Type: application/json');
            echo json_encode($jeux);
        } catch (Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    // Méthode pour ajouter un nouveau jeu
    public function addJeu() {
        // Vérifiez si la clé 'REQUEST_METHOD' existe
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
    
            // Validation des entrées
            if (isset($input['titre']) && isset($input['description']) && isset($input['image'])) {
                $titre = $input['titre'];
                $description = $input['description'];
                $image = $input['image'];
    
                try {
                    $idJeu = $this->jeuModel->ajouterJeu($titre, $description, $image);
                    header('Content-Type: application/json');
                    header("HTTP/1.1 201 Created");
                    echo json_encode(["message" => "Jeu ajouté avec succès.", "Id_jeu" => $idJeu]);
                } catch (Exception $e) {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["error" => $e->getMessage()]);
                }
            } else {
                header("HTTP/1.1 400 Bad Request");
                echo json_encode(["error" => "Données manquantes."]);
            }
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(["error" => "Méthode non autorisée."]);
        }
    }
}
?>