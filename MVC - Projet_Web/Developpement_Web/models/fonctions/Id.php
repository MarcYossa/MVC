<?php

function identifiantPanier() {
    $number = rand(1000000, 9999999); // Génère un nombre entre 1000000 et 9999999
    return "Pa" . $number; // Retourne le préfixe "Ce" suivi du nombre
}



function identifiantArticle() {
    $number = rand(1000000, 9999999); // Génère un nombre entre 1000000 et 9999999
    return "Ar" . $number; // Retourne le préfixe "Ce" suivi du nombre
}



function identifiantCommande() {
    $number = rand(1000000, 9999999); // Génère un nombre entre 1000000 et 9999999
    return "Co" . $number; // Retourne le préfixe "Ce" suivi du nombre
}

function identifiantService() {
    $number = rand(1000000, 9999999); // Génère un nombre entre 1000000 et 9999999
    
    return "Se" . $number; // Retourne le préfixe "Ce" suivi du nombre
}

function identifiantParrain() {
    $number = rand(1000000, 9999999); // Génère un nombre entre 1000000 et 9999999
    return "Pr" . $number; // Retourne le préfixe "Ce" suivi du nombre
}


?>

