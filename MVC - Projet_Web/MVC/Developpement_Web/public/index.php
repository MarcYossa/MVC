<?php
// index.php

// Démarrer la session
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure les fichiers de configuration et d'autoload
require_once '../config/database.php'; // Connexion à la base de données
require_once '../models/User/Utilisateur.php'; // Modèle utilisateur
require_once '../controllers/AuthController.php'; // Contrôleur d'authentification

// Création d'une instance de PDO
$pdo = new PDO($dsn, $user, $pass, $options);

// Initialiser les variables
$id_utilisateur = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$id_parrain = null; // Doit être défini selon votre logique
$id_compte = null; // À définir
$code_parrainage = null; // À définir
$nom_u = null; // À définir
$email = null; // À définir
$tel = null; // À définir
$point_fidelite = 0; // Valeur par défaut
$date_inscription = null; // À définir
$status_compte = 'actif'; // Valeur par défaut

// Création des contrôleurs
$authController = new AuthController($pdo,  $id_utilisateur, $id_parrain, $id_compte, $code_parrainage, $nom_u, $email, $tel, $point_fidelite = 0, $date_inscription = null, $status_compte);

// Analyser l'URL pour déterminer l'action
$requestUri = $_SERVER['REQUEST_URI'];
$parts = explode('/', trim($requestUri, '/'));

// Route par défaut
if (count($parts) === 0 || $parts[0] === '') {
    // Afficher la page d'accueil
    if ($parts[0] === '') {
        require '../views/home.php'; // Assurez-vous que ce chemin est correct
    }
} elseif ($parts[0] === 'login') {
    // Gérer la connexion
    $authController->login();
} elseif ($parts[0] === 'register') {
    // Gérer l'inscription
    $userController = new UserController($pdo,  $id_utilisateur, $id_parrain, $id_compte, $code_parrainage, $nom_u, $email, $tel, $point_fidelite = 0, $date_inscription = null, $status_compte);
    $userController->register();
} elseif ($parts[0] === 'logout') {
    // Gérer la déconnexion
    $authController->logout();
} else {
    // Page non trouvée
    http_response_code(404);
    require '../views/404.php'; // Inclure une page d'erreur 404
}
?>