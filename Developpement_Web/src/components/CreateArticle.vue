<!-- Composante de création des articles -->
<template>
  <body>
   <div class="creermenu">


      <!-- Titre de la fonctionnalité -->
      <h2 class="titre">
          Créer un menu
      </h2>

      <!-- Formulaire pour créer l'article -->
      <form @submit.prevent="CreateArticle" id="Article">
          
              <div class="article">

                  <!-- Label du nom du produit -->
                  <label for="name">Titre</label>
                  <!-- Champ du titre de l'article -->
                  <input type="text" v-model.trim="product.name" id="name" required />
              </div>
            <br><br>
              <div class="categori">
                  <!-- Catégorie -->
                  <label for="category">Catégorie</label>
                  <!-- Champ de catégorie de l'article -->
                  <select v-model.trim="product.category" id="s--category" required>
                      <option value="restauration">Plat</option>
                      <option value="boissons">Boisson</option>
                      <option value="desserts">Dessert</option>
                  </select>
              </div>
              <br><br>
              <div class="prix">
                  <!-- Prix -->
                  <label for="price">Prix</label>

                  <!-- Champ du prix de l'article -->
                  <input type="number" v-model.trim="product.price" id="price" @focus="ClearError" required />
                  <p class="error" v-if="errorPrix">{{ errorPrix }}</p>
              </div>
              <br><br>
              <div class="descrip">
                  <!-- Description de l'article -->
                  <label for="description">Description</label>
                  <!-- Enregistrement d'un petit texte -->
                  <textarea v-model.trim="product.description" id="desc" placeholder="Description de votre article ..." required></textarea>
              </div>
              <br><br>
              <!-- Validation de la création de l'article -->
              <button class="boutton" type="submit" id="validation">
                  Créer
              </button>
              <div class="img-con">
              <img src="../src/assets/WhatsApp Image 2024-10-17 à 10.39.08_b8def022.jpg" alt="img" width="500px" height="500px">
              </div>
      </form>
    </div>
  </body>
</template>

<!-- Interaction -->
<script>
// Importation de la fonction de sécurité pour la création de l'article
import { Security_Prix } from "./components/js/Creer_Articles";

export default {
  name: "CreateArticle",
  data() {
    return {
      product: {
        name: "", // Pour le champ de titre
        price: 0, // Pour le champ de prix
        description: "", // Pour le champ de description
        category: "Plat", // Pour le champ de catégorie
      },
      errorPrix: "", // Pour afficher les erreurs liées au prix
    };
  },
  methods: {
    CreateArticle() {
      // Réinitialisation des messages d'erreur
      this.errorPrix = "";

      // Appel de la fonction de sécurité du prix
      this.errorPrix = Security_Prix(this.product.price);

      // Vérification des erreurs
      if (this.errorPrix) {
        console.log("Votre requête n'a pu être effectuée : ", this.errorPrix);
      } else {
        console.log("L'article peut être créer");

        //Soumission des données ici
      }
    },

    // Réinitialisation des messages d'erreur
    ClearError() {
      this.errorPrix = "";
    }
  }
};
</script>

<!-- Styles -->
<style>
body{
  background-color: #000;
}
.titre{
  color:#CFBD97;
  align-items: left;
  margin-top: 10px;
}
.creermenu{
    width: 1150px;
    height: 720px;
    padding: 80px 90px 65px;
    margin: 50px 50px 50px 50px;
    margin-top: 80px;
    margin-left: 110px;
    border-radius: 5%;
    background: black;
}
.article{
  color: #CFBD97;
  margin-top: 10px;
  align-items: left;
}
.article input {
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
.categori {
    color: #CFBD97;
    margin-top: 10px;
    position: relative;
    align-items: left;
  }
.categori select{
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
.prix{
  color: #CFBD97;
    margin-top: 10px;
    position: relative;
    align-items: left;
}
.prix input{
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
.descrip{
  color: #CFBD97;
    margin-top: 10px;
    position: relative;
    align-items: left;
}
.descrip textarea{
  color: #fff;
    background-color: #2c2c2c;
    font-size: 20px;
    width: 400px;
    padding: 10px 10px 10px 20px;
    border: 1px solid #2c2c2c;
    border-radius: 60px;
    align-items: left;
}
.boutton {
    color: #fff;
    font-size: 20px;
    width: 400px;
    padding: 5px;
    outline: none;
    border: 1px solid #E8B931;;
    border-radius: 60px ;
    background-color: #E8B931;
    transition: background-color 0.3s;
    align-items: left;
}
.img-con {
      align-items: right;
      margin-left: 520px;
      position: absolute;
      bottom: 80px;
}
</style>
