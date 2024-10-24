// Fonction de sécurité du prix
export function Security_Prix(price) {
    console.log("Démarrage de la vérification du prix");

    // Création du message d'erreur
    let errorMessage = "";

    // Vérification que le prix est positif ou égal à 0
    const isValidPrice = price >= 0; // Le prix ne doit pas être négatif

    // Condition de validation
    if (!isValidPrice) {
        console.log("La valeur inscrite est négative");
        errorMessage = "Le prix ne peut pas être négatif"; // Message d'erreur
    } else {
        console.log("Prix valide"); // Validation du prix
        errorMessage = "";
    }

    // Retourner un message d'erreur ou une chaîne vide si tout est correct
    return errorMessage;
}
