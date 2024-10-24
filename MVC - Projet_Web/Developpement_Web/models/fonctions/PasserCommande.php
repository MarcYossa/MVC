Code source

<?php
require_once 'db.php'; // Inclusion du fichier de connexion
require_once __DIR__ . '/../Commande.php'; // Classe Commande
require_once __DIR__ . '/../Service.php'; // Classe Service
require_once 'Id.php'; // Fonctions pour générer des IDs
require_once 'ValidCommande.php'; // Fonctions pour valider les commandes

// Obtention de la connexion à la base de données
$db = Database::getInstance();
$pdo = $db->getConnection(); // Récupération de la connexion PDO

function passerCommande($pdo, $id_utilisateur, $montant, $code_parrain = null, $pt_accumule, $id_personne, $type_s, $statut_s, $commentaire) {
    // Validation des entrées
    if (empty($id_utilisateur) || $montant <= 0 || $pt_accumule < 0) {
        throw new Exception("Données invalides pour passer la commande.");
    }

    try {
        $pdo->beginTransaction(); // Démarrer la transaction

        // Appel de la fonction pour créer la commande
        $commandeResult = createCommande($pdo, $id_utilisateur, $montant, $pt_accumule);
        if (!$commandeResult) {
            throw new Exception("Échec de la création de la commande.");
        }

        $id_commande = $commandeResult;
        $serviceId = createService($pdo, $id_personne, $type_s, $statut_s, $commentaire);
        $associationResult = associerServiceCommande($pdo, $id_commande, $serviceId );
        echo "Commande créée avec succès : " . $id_commande . PHP_EOL;

        // Ajouter les points à l'utilisateur
        ajouterPoints($pdo, $id_utilisateur, $pt_accumule);

        // Vérifier le code de parrainage
        if ($code_parrain) {
            $stmtParrain = $pdo->prepare("SELECT ID_utilisateur FROM Utilisateurs WHERE Code_parrainage = ?");
            $stmtParrain->execute([$code_parrain]);
            $id_parrain = $stmtParrain->fetchColumn();

            if ($id_parrain) {
                // Bonus pour le parrain
                ajouterPoints($pdo, $id_parrain, 5);
                echo "Le parrain a reçu 5 points." . PHP_EOL;
            } else {
                echo "Aucun parrain trouvé pour le code : $code_parrain." . PHP_EOL;
            }
        }

        $pdo->commit(); // Valider la transaction
        return $id_commande;
    } catch (PDOException $e) {
        $pdo->rollBack(); // Annuler la transaction en cas d'erreur
        throw new Exception("Erreur lors de la commande : " . $e->getMessage());
    }
}

function ajouterPoints($pdo, $id_utilisateur, $points) {
    if ($points == 0) return; // Pas besoin d'ajouter 0 points
    // Utilisation du bon nom de colonne
    $stmt = $pdo->prepare("UPDATE Utilisateurs SET Point_fidelite = Point_fidelite + ? WHERE ID_utilisateur = ?");
    $stmt->execute([$points, $id_utilisateur]);
}

function utiliserPoints($pdo, $id_utilisateur, $points_a_utiliser) {
    // Vérifier si l'utilisateur a suffisamment de points
    $stmt = $pdo->prepare("SELECT Point_fidelite FROM Utilisateurs WHERE ID_utilisateur = ?");
    $stmt->execute([$id_utilisateur]);
    $points_disponibles = $stmt->fetchColumn();

    if ($points_disponibles < $points_a_utiliser) {
        throw new Exception("Pas assez de points de fidélité.");
    }

    // Calcul de la réduction
    $reduction = floor($points_a_utiliser / 15) * 1000; // 1000 F de réduction pour 15 points

    // Déduire les points
    ajouterPoints($pdo, $id_utilisateur, -$points_a_utiliser);

    return $reduction; // Retourner la réduction appliquée
}
?>






