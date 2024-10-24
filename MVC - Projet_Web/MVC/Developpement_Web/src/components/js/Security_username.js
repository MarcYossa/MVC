// Fonction pour la sécurité du Username
export function Validation_Username(username) {
    console.log("Démarrage de la vérification du username");

    // Création d'un message d'erreur
    let errorMessage = "";

    const hasValidLength = username.length >= 3; // Longueur minimal de caractère 3
    // Vérification
    const HasNumber = /[0-9]/; // Chiffre
    const HasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/; // Caractère spécial

    // Combinaison des caractéristique
    const Validation = !HasNumber.test(username) && !HasSpecialChar.test(username);

    // Condition de validation
    if(!hasValidLength) {
        console.log("Le nom d'utilisateur est trop court");
        errorMessage = "Au minimun 3 caractère"; // Message d'erreur

    } else if(!Validation) {
        console.log("Nom d'utilisateur invalide");
        errorMessage = "Ce champ ne doit contenir que des lettres"; // Message d'erreur

    } else {
        console.log("Nom d'utilisateur valide"); // Validation de username
        errorMessage = "";
    }

    //Retourner le message d'erreur ou la chaîne vide
    return errorMessage;
}