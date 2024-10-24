<?php

require_once 'db.php'; // Connexion à la base de données
require_once __DIR__ . '/../Commande.php'; // Classe Commande
require_once __DIR__ . '/../Service.php'; // Classe Service
require_once 'Id.php'; // Fonctions pour générer des IDs

error_reporting(E_ALL); // Activer le rapport d'erreurs
ini_set('display_errors', 1); // Afficher les erreurs à l'écran

// Fonction générique pour exécuter des requêtes
function executeQuery($pdo, $query, $params) {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt;
}

// Fonction pour gérer l'exécution sécurisée des requêtes
function safeExecute($pdo, $query, $params) {
    try {
        executeQuery($pdo, $query, $params);
        return "Exécution réussie"; // Retournez un message de succès
    } catch (PDOException $e) {
        return "Erreur : " . $e->getMessage();
    }
}

// Fonction pour ajouter un service
function createService($pdo, $id_personne, $type_s, $statut_s = 'en attente', $commentaire = '') {
    $id_service = identifiantService(); // Générer un nouvel ID de service

    // Vérifiez que l'ID est valide
    if (empty($id_service)) {
        echo "Erreur : ID de service généré est vide.\n";
        return null; // Retourner null si l'ID est vide
    }

    $service = new Service($pdo, $id_service, $id_personne, $type_s, $statut_s, $commentaire);
    
    // Ajout du service à la base de données
    $result = ajouterService($pdo, $service);
    if ($result === "Exécution réussie") {
        echo "Service ajouté avec succès, ID : $id_service\n"; // Afficher l'ID du service
        return $id_service; // Retourner l'ID du service créé
    } else {
        echo "Erreur lors de l'ajout du service : $result\n";
        return null; // Retourner null en cas d'échec
    }
}

// Fonction pour ajouter le service dans la base de données
function ajouterService($pdo, $service) {
    $query = "INSERT INTO Service (ID_service, ID_personne, Type_s, statut_s, Commentaire) VALUES (?, ?, ?, ?, ?)";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            $service->getIdService(),
            $service->getIdPersonne(),
            $service->getTypeS(),
            $service->getStatutS(),
            $service->getCommentaire()
        ]);
        echo "Service ajouté avec succès : " . $service->getIdService() . PHP_EOL; // Message de succès
        return "Exécution réussie"; // Retournez un message de succès
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout du service : " . $e->getMessage() . PHP_EOL; // Afficher l'erreur
        return "Échec"; // Retourner un message d'échec
    }
}
// Fonction pour récupérer un service par ID
function recupererService($pdo, $id_service) {
    $stmt = $pdo->prepare("SELECT * FROM Service WHERE ID_service = ?");
    $stmt->execute([$id_service]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour créer une commande
function createCommande($pdo, $id_utilisateur, $montant, $pt_accumule) {
    $id_commande = identifiantCommande(); // Générer un nouvel ID de commande
    $commande = new Commande($pdo, $id_commande, $id_utilisateur, $montant, $pt_accumule);
    return validerCommande($pdo, $commande);
}

// Fonction pour valider la commande et l'ajouter à la base de données
function validerCommande($pdo, $commande) {
    $query = "INSERT INTO Commandes (ID_commande, ID_utilisateur, Montant, Pt_accumule, date_commande) 
              VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";
    
    $stmt = $pdo->prepare($query);
    if (!$stmt->execute([
        $commande->getIdCommande(),
        $commande->getIdUtilisateur(),
        $commande->getMontant(),
        $commande->getPtAccumule()
    ])) {
        $errorInfo = $stmt->errorInfo();
        throw new Exception("Erreur lors de l'insertion de la commande : " . implode(", ", $errorInfo));
    }
    return $commande->getIdCommande();
}

// Fonction pour associer un service à une commande
function associerServiceCommande($pdo, $id_commande, $id_service) {
    $query = "INSERT INTO Utiliser (ID_commande, ID_service) VALUES (?, ?)";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id_commande, $id_service]);
        return "Exécution réussie"; // Retournez un message de succès
    } catch (PDOException $e) {
        return "Erreur lors de l'association : " . $e->getMessage();
    }
}
// Fonction pour exécuter le service et la commande
function executeServiceAndCommande($pdo, $id_personne, $id_utilisateur, $type_s, $montant, $pt_accumule, $statut_s = 'en attente', $commentaire = '') {
    try {
        // Créer un nouveau service
        echo "Création d'un nouveau service...\n";
        $serviceId = createService($pdo, $id_personne, $type_s, $statut_s, $commentaire);
        
        if ($serviceId === null) {
            echo "Erreur lors de la création du service.\n";
            return; // Terminer si le service n'a pas été créé
        }
        
        echo "Service créé avec ID : $serviceId\n";

        // Créer une nouvelle commande
        echo "Création d'une nouvelle commande...\n";
        $commandeId = createCommande($pdo, $id_utilisateur, $montant, $pt_accumule);
        
        if ($commandeId === null) {
            echo "Erreur lors de la création de la commande.\n";
            return; // Terminer si la commande n'a pas été créée
        }
        
        echo "Commande créée avec ID : $commandeId\n";

        // Associer le service à la commande
        echo "Association du service à la commande...\n";
        $associationResult = associerServiceCommande($pdo, $commandeId, $serviceId);
        
        if ($associationResult !== "Exécution réussie") {
            echo "Erreur lors de l'association du service à la commande : $associationResult\n";
        } else {
            echo "Service associé à la commande avec succès.\n";
        }

    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

// Exemple d'utilisation
// Assurez-vous d'appeler cette fonction avec des paramètres valides

?>
