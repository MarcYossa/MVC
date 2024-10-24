<?php
// Inclusion du fichier de configuration contenant les paramètres de la base de données
require_once 'config.php';

class Database {
    // Instance unique de la classe Database
    private static $instance = null;
    // Connexion PDO
    private $connection;

    // Constructeur privé pour empêcher l'instanciation de la classe en dehors de la classe elle-même
    private function __construct() {
        // Création de la connexion PDO
        $this->connection = new PDO(
            "mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, 
            DB_USERNAME, 
            DB_PASSWORD
        );
        // Configuration des attributs de la connexion
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Méthode statique pour obtenir l'instance unique de la classe Database
    public static function getInstance() {
        // Si l'instance n'existe pas encore, on la crée
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        // Retourne l'instance unique
        return self::$instance;
    }

    // Méthode pour obtenir la connexion PDO
    public function getConnection() {
        return $this->connection;
    }

    // Méthode privée pour empêcher la clonage de l'instance
    private function __clone() { }

    // Méthode privée pour empêcher la désérialisation de l'instance
    public function __wakeup() { }
}
?>