// Fonction pour la validation de l'adresse email
export function Validation_mail(email) {
    console.log("Démarrage de la vérification de l'email");

    // Création d'un message d'erreur
    let errorMessage = "";
    const Regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // Condition : Si l'utilisateur n'entre pas les valeurs correctement
    if (!Regex.test(email)) {
        console.log("L'email est incorrect");
        errorMessage = "Email invalide";
    } else {
        console.log("Email correct");
        errorMessage = "";
    }
    
    // Retourner le message d'erreur ou une chaîne vide
    return errorMessage; 
}