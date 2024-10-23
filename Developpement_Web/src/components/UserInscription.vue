<!-- Elément intérieur de la page d'inscription-->
<template>
  <body>
       <div class="page_Création">
           <div class="form_Cre">
               <h1> Créer un compte </h1>
               <form id="monFormulaire" action="enregistrer.php" method="POST">
                   
                   <div class="form-email">
                       <label for="Email"> Email</label>
                       <br><br>
                       <input v-model.trim="email" @focus="ClearError" placeholder="Adresse e-mail" type="email" id="email" required/>
                      <p v-if="errorEmail" class="error">{{ errorEmail }}</p>

                     <br><br>
                   </div>
                   <div class="form-niveaux">
                       <label for="Niveaux"> Mot de passe </label>
                       <br><br>
                       <input v-model="password" @focus="ClearError" placeholder="Créer un mot de passe" type="password" id="password" required/>
           <p v-if="errorPassword" class="error">{{ errorPassword }}</p>
                   </div>
                   <div class="form-password">
                   <label for="password">Confirmer mot de passe :</label>
                   <br><br>
                   <input v-model="confirm_password" @focus="ClearError" type="password" placeholder="Confirmer votre mot de passe" id="confirm_password" required/>
           <p v-if="errorConfirmPassword" class="error">{{ errorConfirmPassword }}</p>
                   </div>
                   <div class="Conn_foot">
                       <button type="submit" onclick="location.href='index.php?page=index_Créer_Compte'" class="connexion">Créer un compte </button>
                   </div>
                   </form>
                   
           </div>
           <div class="img-con">
           <img src="../src/assets/WhatsApp Image 2024-10-17 à 10.39.08_b8def022.jpg" alt="img" width="500px" height="500px">
           </div>
       </div>
   </body>
</template>

 <script>
 // Importation des fonctions de validation
 import { Validation_mail } from "./components/js/Security_mail";
 import { Validation_Password } from "./components/js/Security_Password";
 import { Validation_Username } from "./components/js/Security_username";
 
 export default {
   name: "UserInscription",
   data() {
     return {
       username: "", // Pour le champ du nom de famille
       firstname: "", // Pour le champ du prénom 
       email: "", // Pour le champ de l'email
       password: "", // Pour le champ du mot de passe
       confirm_password: "",// Pour le champ de confirmation du mot de passe
       errorEmail: "", // Pour afficher les messages d'erreur d'email
       errorUsername: "", // Pour afficher le message d'erreur du username
       errorFirstname: "", // Pour afficher l'erreur du firstname
       errorPassword: "", // Pour afficher les messages d'erreur de mot de passe
       errorConfirmPassword: "" // Pour afficher les messages d'erreur de confirmation de mot de passe
     };
   },
   
   methods: {
     Formulaire() {
       // Réinitialiser les messages d'erreur
       this.errorUsername = "";
       this.errorEmail = ""; 
       this.errorPassword = "";
       this.errorConfirmPassword = "";
 
       // Appeler la fonction de validation de l'email
       this.errorEmail = Validation_mail(this.email);
       // Appeler la fonction de validation du mot de passe
       this.errorPassword = Validation_Password(this.password);
       // Appel de la condition sur le username
       this.errorUsername = Validation_Username(this.username);
 
       // Combinaison des deux erreur
       this.errorFirstname = this.errorUsername;
 
       // Vérifier si le mot de passe et la confirmation correspondent
       if (this.password !== this.confirm_password) {
         this.errorConfirmPassword = "Les mots de passe ne correspondent pas.";
       }
       
       // Vérifier s'il y a des erreurs
       else if (this.errorUsername || this.errorEmail || this.errorPassword || this.errorConfirmPassword) {
         console.log("Le formulaire n'est pas envoyé :", this.errorUsername, this.errorEmail, this.errorPassword, this.errorConfirmPassword);

       } else {
         console.log("Les informations ont été envoyées");
         
         // Vous pouvez ajouter ici le code pour soumettre les données
       }
     },

     // Réinitialisation des messages d'erreur
     ClearError() {
       this.errorEmail = "";
       this.errorPassword = "";
       this.errorConfirmPassword = "";
     },
   },
 };
 </script>
 
 <style>
*{
   padding: 0;
   margin: 0;
   box-sizing: border-box;
}
/* Style CSS des éléments de l'en-tête*/

/* Changer la couleur de fond de la page web */
html {
   background: black;
}

.page_Création{
   width: 1150px;
   height: 720px;
   padding: 80px 90px 65px;
   margin: 50px 50px 50px 50px;
   margin-top: 80px;
   margin-left: 110px;
   border-radius: 5%;
   background: black;
}

.form_Cre {
   color: #CFBD97;
   align-items: left;
   margin-top: 50px;
}

.form-email{
   margin-top: 10px;
   align-items: left;
}

.form-email input {
   color: #fff;
   background-color: #2c2c2c;
   font-size: 20px;
   width: 400px;
   outline: none;
   padding: 10px 10px 10px 20px;
   border: 1px solid #2c2c2c;
   border-radius: 60px;
   align-items: left;
}

.form-niveaux input{
   color: #fff;
   font-size: 20px;
   background-color: #2c2c2c;
   width: 400px;
   outline: none;
   padding: 10px 10px 10px 20px;
   border: 1px solid #2c2c2c;
   border-radius: 60px;
   align-items: left;
}

.form-password {
   margin-top: 10px;
   position: relative;
   align-items: left;
}

.form-password input {
   color: #fff;
   font-size: 20px;
   background-color: #2c2c2c;
   width: 400px;
   outline: none;
   padding: 10px 10px 10px 20px;
   border: 1px solid #2c2c2c;
   border-radius: 60px;
   align-items: left;
}

.Conn_foot {
   margin-top: 50px;
   align-items: left;
}

.Conn_foot button {
   color: #fff;
   font-size: 20px;
   width: 400px;
   padding: 5px;
   outline: none;
   border: 1px solid #E8B931;
   border-radius: 60px ;
   background-color: #E8B931;
   transition: background-color 0.3s; /* Ajoute une transition pour l'effet visuel */
   align-items: left;
}

.Conn_foot button:hover {
   background-color: #ccc;
}

.Conn_foot p {
   margin-top: 30px;
   margin-left: 100px;
   align-items: left;
}

.Conn_foot a {
   color: #E8B931;
   margin-top: 80px;
   margin-left: 250px;
   align-items: left;
}

.img-con {
   align-items: right;
   margin-top: 14x;
   margin-left: 540px;
   position: absolute;
   bottom: 0px;
}

</style>
