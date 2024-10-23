// Fonction de validation du mot de passe
export function Validation_Password(password) {
    console.log("Démarrage de la vérification du mot de passe");
    
    // Création d'un message d'erreur
    let errorMessage = "";
    
    // Vérifications
    const HasLetter = /^(?=.*[A-Z])(?=.*[a-z])/; // Au moins une lettre majuscule et une lettre minuscule
    const HasNumber = /[0-9]/; // Au moins un chiffre
    const HasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/; // Au moins un caractère spécial

    // Vérification des caractéristiques
    const hasValidLength = password.length >= 8; // Longueur minimale de 8 caractères
    const validation = HasLetter.test(password) && HasNumber.test(password) && HasSpecialChar.test(password);

    // Conditions de validation
    if (!hasValidLength) {
        console.log("Le mot de passe est trop court");
        errorMessage = "Votre mot de passe doit contenir au moins 8 caractères.";
    } else if (!validation) {
        console.log("Le mot de passe est invalide");
        errorMessage = "Votre mot de passe doit contenir des chiffres, des lettres majuscules et minuscules, ainsi qu'un caractère spécial.";
    } else {
        console.log("Mot de passe correct");
        errorMessage = ""; // Aucun message d'erreur
    }

    // Retourner le message d'erreur ou une chaîne vide
    return errorMessage;
}