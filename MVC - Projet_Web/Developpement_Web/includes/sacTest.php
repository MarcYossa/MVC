test pour la fonction Ajouter panier

<?php
require_once __DIR__ . '/db.php';          // Chemin vers db.php
require_once __DIR__ . '/config.php';      // Chemin vers config.php
require_once __DIR__ . '/../models/Panier.php'; // Chemin vers Panier.php
require_once __DIR__ . '/../models/fonctions/AjouterPanier.php'; // Chemin vers AjouterPanier.php

function testAjouterArticleAuPanier($id_utilisateur, $id_article) {
    // Obtenir la connexion
    $pdo = Database::getInstance()->getConnection();

    // Appeler la fonction pour ajouter l'article au panier
    $message = ajouterArticleAuPanier($pdo, $id_utilisateur, $id_article);
    echo $message . "<br>";

    // Vérifier le contenu de la table Selectionner
    // Remplacez 'Plats' par 'Article' et ajustez la requête si nécessaire
    $stmt = $pdo->prepare("SELECT * FROM Selectionner WHERE ID_utilisateur = ? AND ID_plat = ?");
    $stmt->execute([$id_utilisateur, $id_article]);
    $selections = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Contenu du panier : <br>";
    foreach ($selections as $selection) {
        echo "Article ID: " . $selection['ID_plat'] . "<br>";
        // Si vous avez une logique de quantité, ajoutez-la ici
    }
}

// Exécuter le test
testAjouterArticleAuPanier('U102', 'P101'); // Remplacez 'U101' et 'P101' par des ID valides
?>


test pour la fonction Validcommande


<?php

require_once __DIR__ . '/db.php';          // Chemin vers db.php
require_once __DIR__ . '/config.php';      // Chemin vers config.php
require_once __DIR__ . '/../models/Commande.php'; // Chemin vers Panier.php
require_once __DIR__ . '/../models/fonctions/ValidCommande.php'; // Chemin vers AjouterPanier.php
require_once __DIR__ . '/../models/Service.php'; 
try {
    $pdo = Database::getInstance()->getConnection();


    // Créer un nouveau service
    echo "Création d'un nouveau service...\n";
    $result = createService($pdo, 'P101', 'Type de service', 'en attente', 'Commentaire ici');
    echo $result . PHP_EOL;

    // Récupérer un service
    echo "Récupération du service...\n";
    $serviceDetails = recupererService($pdo, 'Se335004'); // Remplacez 'S001' par l'ID généré si nécessaire
    echo "Détails du service : ";
    print_r($serviceDetails);

    // Créer une nouvelle commande
    echo "Création d'une nouvelle commande...\n";
    $commandeResult = createCommande($pdo, 'U102', 100, 10);
    echo $commandeResult . PHP_EOL;

    // Associer le service à la commande
    echo "Association du service à la commande...\n";
    $associationResult = associerServiceCommande($pdo, 'Co255972', 'Se3350041'); // Remplacez 'C001' par l'ID de votre commande
    echo $associationResult . PHP_EOL;

} catch (PDOException $e) {
    echo "Erreur lors de l'exécution : " . $e->getMessage();
}

?>


<?php
require_once __DIR__ . '/db.php'; // Chemin vers db.php
require_once __DIR__ . '/config.php'; // Chemin vers config.php
require_once __DIR__ . '/../models/Panier.php'; // Chemin vers Panier.php
require_once __DIR__ . '/../models/fonctions/PasserCommande.php'; // Chemin vers PasserCommande.php

$id_utilisateur = 'Ut141654'; // Remplace par l'ID d'un utilisateur existant
$code_parrain = null; // Ou remplace par l'ID d'un parrain existant si nécessaire
$montant = 5000; // Montant de la commande
$pt_accumule = 10; // Points à accumuler

// Obtention de la connexion à la base de données
$db = Database::getInstance();
$pdo = $db->getConnection(); // Récupération de la connexion PDO

// Vérification de l'existence de l'utilisateur
$stmt = $pdo->prepare("SELECT COUNT(*) FROM Utilisateurs WHERE ID_utilisateur = ?");
$stmt->execute([$id_utilisateur]);
if ($stmt->fetchColumn() == 0) {
    die("Erreur : L'utilisateur $id_utilisateur n'existe pas.");
}

// Validation des montants
if ($montant <= 0) {
    die("Erreur : Le montant doit être supérieur à zéro.");
}
if ($pt_accumule < 0) {
    die("Erreur : Les points accumulés ne peuvent pas être négatifs.");
}

// Appel de la fonction passerCommande
try {
    $id_commande = passerCommande($pdo, $id_utilisateur, $montant, $code_parrain, $pt_accumule);
    echo "Commande passée avec succès, ID commande : " . $id_commande . PHP_EOL;
} catch (Exception $e) {
    echo "Erreur lors de la commande pour l'utilisateur $id_utilisateur : " . $e->getMessage() . PHP_EOL;
}

// Vérifier les points de l'utilisateur
$stmt = $pdo->prepare("SELECT Point_fidelite FROM Utilisateurs WHERE ID_utilisateur = ?");
$stmt->execute([$id_utilisateur]);
$points_utilisateur = $stmt->fetchColumn();

echo "Points de l'utilisateur après la commande : " . $points_utilisateur . PHP_EOL;

// Si tu as un parrain, vérifie aussi ses points
if ($code_parrain) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Utilisateurs WHERE ID_utilisateur = ?");
    $stmt->execute([$code_parrain]);
    if ($stmt->fetchColumn() > 0) {
        $stmt = $pdo->prepare("SELECT Point_fidelite FROM Utilisateurs WHERE ID_utilisateur = ?");
        $stmt->execute([$code_parrain]);
        $points_parrain = $stmt->fetchColumn();
        echo "Points du parrain après la commande : " . $points_parrain . PHP_EOL;
    } else {
        echo "Erreur : Le parrain avec ID $code_parrain n'existe pas." . PHP_EOL;
    }
}
?>



<?php

require_once __DIR__ . '/db.php';          // Chemin vers db.php
require_once __DIR__ . '/config.php';      // Chemin vers config.php
require_once __DIR__ . '/../models/Commande.php'; // Chemin vers Panier.php
require_once __DIR__ . '/../models/fonctions/ValidCommande.php'; // Chemin vers AjouterPanier.php
require_once __DIR__ . '/../models/Service.php'; 
// Exemple d'utilisation
function runTests() {
    // Connexion à la base de données
    $pdo = Database::getInstance()->getConnection();

    // Appeler la fonction principale avec des exemples de données
    executeServiceAndCommande($pdo, 'P101', 'U101', 'Type de service', 100, 10, 'en attente', 'Commentaire ici');
}

// Exécuter les tests
runTests();
?>