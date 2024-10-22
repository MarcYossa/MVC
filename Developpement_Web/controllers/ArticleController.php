<?php
// controllers/ArticleController.php

require_once '../models/Article/Creation.php';
require_once '../models/Article/Modify.php';
require_once '../models/Article/Suppression.php';

class ArticleController {
    private $articleModel;
    private $modifyModel;
    private $suppressModel;

    public function __construct() {
        $this->articleModel = new Creation();
        $this->modifyModel = new Modify();
        $this->suppressModel = new Suppression();
    }

    public function showAddArticle() {
        require_once '../views/AddArticle.php'; // Afficher le formulaire d'ajout
    }

        // Méthode d'addition d'un article 
    public function addArticle() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id_plat = $_POST['id_plat'];
                $nom_m = $_POST['nom_m'];
                $description_m = $_POST['description_m'];
                $prix = $_POST['prix'];
                $disponible = $_POST['disponible'];

                $this->articleModel->ajouterArticle($id_plat, $nom_m, $description_m, $prix, $disponible);
                echo "L'article a été ajouté avec succès !";
            } catch (Exception $e) {
                session_start();
                $_SESSION['error'] = $e->getMessage();
                header("Location: /views/AddArticle.php");
                exit();
            }
        } else {
            echo "Méthode de requête non supportée.";
        }
    }

    // Méthode de mise à jour d'un article
    public function editArticle() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id_plat = $_POST['id_plat']; // ID_PLAT à ne pas modifier
                $nom_m = $_POST['nom_m'];
                $description_m = $_POST['description_m'];
                $prix = $_POST['prix'];
                $disponible = $_POST['disponible'];

                $this->modifyModel->modifierArticle($id_plat, $nom_m, $description_m, $prix, $disponible);
                echo "L'article a été modifié avec succès !";
            } catch (Exception $e) {
                session_start();
                $_SESSION['error'] = $e->getMessage();
                header("Location: /controllers/ArticleController.php?action=showEditArticle&id_plat=" . $id_plat);
                exit();
            }
        } else {
            echo "Méthode de requête non supportée.";
        }
    }

    // Méthode de suppression d'un article
    public function deleteArticle($id_plat) {
        try {
            $this->suppressModel->supprimerArticle($id_plat);
            echo "L'article a été supprimé avec succès !";
            // Redirection ou message de confirmation ici
        } catch (Exception $e) {
            session_start();
            $_SESSION['error'] = $e->getMessage();
            // Redirection ou gestion de l'erreur ici
        }
    }
}
?>