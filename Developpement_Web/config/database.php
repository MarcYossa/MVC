<?php
// database.php
class Database {
    private static $instance = null;
    private static $connection; // Stocke la connexion PDO
    private $pdo;

    private function __construct() {
        $host = 'localhost'; // ou l'adresse de votre serveur
        $db = 'developpemnt_web'; // Remplacez par le nom de votre base de données
        $user = 'root'; // Remplacez par votre nom d'utilisateur de base de données
        $pass = ''; // Remplacez par votre mot de passe de base de données
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    // Méthode pour remplacer la connexion par un mock
    public static function setConnection($mockConnection) {
        self::$connection = $mockConnection; // Remplace la connexion par le mock
    }
}
?>
