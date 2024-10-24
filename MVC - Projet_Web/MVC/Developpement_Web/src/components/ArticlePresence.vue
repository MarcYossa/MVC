<template>
  <body>
  <!-- Composition interne du site -->
  <div id="global--p">
   
      <!-- Contenu interne position droite-->
      <div class="comp--img">

        <!-- Image -->
        <img src="../src/assets/WhatsApp Image 2024-10-07 à 21.1 (1).jpg" alt="logo" class="img--art" style="margin-right: 40px ;">
      </div>
      <div class=espace>
      <!-- Contenu interne position gauche-->
      <div class="contenu--int">

        <!-- Titre de l'article-->
        <h2 id="titre">
          Article
        </h2>

        <!-- Sous-titre prix -->
        <h3 id="s--prix">
          @Zeduc-Sp@ce <span id="prix"> 1000 FCFA</span>
        </h3>

        <!-- -->
        <label for="texte">
          Quantité
         </label>
         <br><br>
        <!-- Forme -->
        <form @submit.prevent="Commande" id="Forme">
          <div class="g--increment">

            <!-- Décrementation avec le bouton "-" -->
            <button @click="DecrementCounter">-</button>

            <!-- Implementation dans un champ de d'entrée-->
            <input type="text" v-model="counter" id="quantite" @input="Incompatible">

            <!-- Incrémentation avec le bouton "+" -->
            <button @click="IncrementCounter">+</button>
          </div>

          <!-- Message d'erreur -->
          <p class="error" v-if="errorMessage">{{ errorMessage }}</p>
        <br><br>
          <!-- Soumettre le formulaire -->
          <input type="submit" value="Commander" id="commande">
        </form>
        <br><br>
        <div class="g--desc" style="display:grid;">
          <!-- Titre de description -->
          <label for="titre">Description</label>
          <!-- Description du produit -->
          <p class="description">
            D'où vient cette spécialité ? 
            Le poulet « directeur général » est un plat camerounais né dans les années 80. À cette époque, 
            il était surtout servi aux personnes de la haute société en guise de reconnaissance et de respect. 
            Heureusement, 
            la spécialité s'est démocratisée avec le temps !
          </p>
        </div>
      </div>
      </div>
    </div>
    </body>
</template>

<!-- Interaction du site web -->
<script>
export default {
  name: "ArticlePresent",
  data() {
    return {
      counter: 1, // Valeur de saisie
      errorMessage: "", // Message d'erreur
    };
  },

  methods: {
    // Fonction de décrementation action du click
    DecrementCounter() {
      // Condition 
      if (this.counter > 1) {
        this.errorMessage = ""; // Message d'erreur 
        this.counter--; // Décrmentation 

      }
    },

    // Fonction pour incrémentation 
    IncrementCounter() {
      //incrementation
      this.errorMessage = ""; // Messaged'erreur initial
      this.counter++; // Incrémentation 

    },

    //  Fonction d'affichage du message d'erreur 
    Incompatible() {

      //condition
      if(this.counter <0) {
        this.errorMessage = "Au minimum (1) produit";
        this.counter = 1;

      } else {
        this.errorMessage ="";
      }

    },

    // Fonction de validation de l'envoie 
    Commande() {
      // Appel de la fonction de la quantité inscrite
      const Incompatible = Incompatible();

      //Condition
      if(!Incompatible) {
        console.log("Votre requête est refusé !");
        
      } else {
        // Envoie de la requête
      }
    }

  }
}
</script>
<style>
body{
  background-color: #000;
}
.contenu--int{
  color: #cfbd97;
}
#global--p{
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
.g--desc{
  background-color: #2c2c2c;
  border-radius: 20px;
  border-color:  white;
  font-size: 20px;
}
input{
  color: #fff;
  font-size: 20px;
  width: 400px;
  padding: 5px;
  outline: none;
  border: 1px solid #E8B931;;
  border-radius: 60px ;
  background-color: #E8B931;
  transition: background-color 0.3s;
  align-items: left
}

</style>