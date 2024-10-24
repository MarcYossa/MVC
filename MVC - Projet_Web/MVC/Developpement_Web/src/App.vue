<!-- Elément de la page de connexion -->
<template>
    <body>
      <div class="page_Se_connecter">
        <div class="form_Con">
          <h1> Se connecter </h1>
            <form>
              <div class="form-email">
                <label for="email">Email :</label>
                <br><br>
                <input type="email" v-model="email" id="email" @focus="ClearError" placeholder="Adresse email" required>
                <p v-if="errorEmail" class="error"> {{ errorEmail }}</p>
                 <br><br>
                  </div>
                      <div class="form-password">
                      <label for="password">Mot de passe :</label>
                      <br><br>
                      <input type="password" v-model="password" id="password" @focus="ClearError" placeholder="Mot de passe" required>
                      <p v-if="errorPassword" class="error"> {{ errorPassword }} </p>
                      <p> Mot de passe oublié ?</p>
                      </div>
                      </form>
                      <div class="Conn_foot">
                          <button> Se connecter </button>
              </div>
              <div class="img-con">
              <!--img src="../src/assets/WhatsApp Image 2024-10-17 à 10.39.08_b8def022.jpg" alt="img" width="500px" height="500px"-->
              </div>
          </div>
      </div>
    </body>
  </template>
  
  <!-- Interaction javascript -->
  <script>
  // Importation du module de vérification d'un mail
  import { Validation_mail } from "./components/js/Security_Password";
  import { Validation_Password } from "./components/js/Security_Password";
  
  export default {
    name: "UserConnexion", // Nom du composant créer
    data() {
        return {
            email: "", // Pour le champ email
            password: "", // Pour le champ password
            errorEmail: "", // Pour afficher le message d'erreur de l'email
            errorPassword: "", // Pour afficher le message d'erreur du password
        };
    },
  
    methods : {
        // Fonction de validation du formulaire
        Formulaire() {
            // Reintialisation des messages d'erreur
            this.errorEmail = "";
            this.errorPassword = "";
  
            // Appel de la fonction de sécurité de l'email
            this.errorEmail = Validation_mail(this.email);
            // Appel de la fonction de sécurité du password
            this.errorPassword = Validation_Password(this.password);
  
            // Vérifier s'il y a des erreur  
            if (this.errorEmail || this.errorPassword) {
                console.log("Le formulaire n'a été envoyé :", this.errorEmail, this.errorPassword);
            } else {
                console.log("Le formulaire a été envoyé");
            }
  
        },
  
        //Reinitialisation de messages d'erreur
        ClearError() {
            this.errorEmail = "";
            this.errorPassword = "";
        }
    }
  }
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
  
  .page_Se_connecter{
      align-items: center;
      width: 1150px;
      display: flex;
      padding: 80px 90px 65px;
      margin: 50px 50px 50px 50px;
      margin-top: 100px;
      margin-left: 170px;
      background:#000;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Ajout d'ombre */
  }
  
  .form_Con {
      color:#CFBD97;
      align-items: left;
      margin-top: 10px;
  }
  
  .form-email{
      margin-top: 30px;
      align-items: left;
  }
  
  .form-email input {
      color: #fff;
      font-size: 20px;
      width: 400px;
      outline: none;
      padding: 10px 10px 10px 20px;
      border: 1px solid #2c2c2c;
      border-radius: 60px;
      align-items: left;
      background-color: #2c2c2c;  
  }
  
  .form-password {
      margin-top: 10px;
      position: relative;
      align-items: left;
  }
  
  .form-password input {
      color: #fff;
      font-size: 20px;
      width: 400px;
      outline: none;
      padding: 10px 10px 10px 20px;
      border: 1px solid #2c2c2c;
      border-radius: 45px;
      align-items: left;
      background-color: #2c2c2c;
  }
  
  .form-password img {
      position: absolute;
      margin-top: 8px;
      margin-left: 360px;
      align-items: left;
  }
  .form-password p {
      margin-top: 10px;
      margin-left: 260px;
      color: #CFBD97;
      align-items: left;
  }
  .Conn_foot {
      margin-top: 30px;
      align-items: left;
  }
  .Conn_foot button {
      color: #fff;
      font-size: 20px;
      width: 400px;
      padding: 5px;
      outline: none;
      border: 1px solid #E8B931;;
      border-radius: 60px ;
      background-color: #E8B931;
      transition: background-color 0.3s; /* Ajoute une transition pour l'effet visuel */
      align-items: left;
  }
  .Conn_foot button:hover {
      background-color: #ccc;
  }
  .Conn_foot p {
      margin-top: 20px;
      margin-left: 90px;
      align-items: left;
  }
  .Conn_foot a {
      color: #E8B931;
      margin-top: 80px;
      margin-left: 230px;
      align-items: left;
  }
  .img-con {
      align-items: right;
      margin-left: 520px;
      position: absolute;
      bottom: 80px;
  }
  </style>