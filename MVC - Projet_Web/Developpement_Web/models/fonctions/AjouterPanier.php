<?php
require_once 'db.php';
require_once __DIR__ . '/../Article.php'; // Chemin vers Article.php
require_once __DIR__ . '/../Panier.php'; // Chemin vers Panier.php
require_once 'Id.php';

function ajouterArticleAuPanier($pdo, $id_utilisateur, $id_article) {
    // Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT ID_utilisateur FROM Utilisateur WHERE ID_utilisateur = ?");
    $stmt->execute([$id_utilisateur]);
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        return "L'utilisateur n'existe pas.";
    }

    // Vérifier si l'article existe
    $stmt = $pdo->prepare("SELECT * FROM Article WHERE ID_plat = ?");
    $stmt->execute([$id_article]);
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        return "L'article n'existe pas.";
    }

    // Vérifier si le panier existe pour cet utilisateur
    $stmt = $pdo->prepare("SELECT ID_panier FROM Panier WHERE ID_utilisateur = ?");
    $stmt->execute([$id_utilisateur]);
    $panierData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$panierData) {
        // Créer un nouveau panier si inexistant
        $id_panier = identifiantPanier(); // Méthode pour générer un nouvel ID
        $panier = new Panier($pdo, $id_panier, $id_utilisateur);
        $panier->create(); // Créer le panier
    }

    // Ajouter l'article à la sélection, même s'il existe déjà
    $stmt = $pdo->prepare("INSERT INTO Selectionner (ID_utilisateur, ID_plat) VALUES (?, ?)");
    $stmt->execute([$id_utilisateur, $id_article]);

    return "Article ajouté au panier avec succès.";

}
?>