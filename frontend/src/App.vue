<template>
  <!-- Application principale encadrée par Vuetify -->
  <v-app>
    <v-container>
      <!-- Titre principal -->
      <h1 class="text-h4 mb-4">Gestionnaire de Recettes</h1>

      <!-- Barre de recherche pour filtrer les recettes par ingrédient -->
      <SearchBar @search="handleSearch"/>

      <!-- Formulaire pour ajouter ou modifier une recette-->
      <RecipeForm
      :editData="selectedRecipe"
      @create-recipe="createRecipe"
      @update-recipe="updateRecipe"
      @cancel-edit="selectedRecipe = null"
      />

      <!-- Liste des recettes filtrées -->
      <RecipeList
      :recipes="filteredRecipes"/>
      @edit="selectedRecipe = $event"
      @delete="deleteRecipe" 


    </v-container>
  </v-app>
  
</template>

<script>
// Import des composant enfants
import RecipeForm from './components/RecipeForm.vue';
import RecipeList from './components/RecipeList.vue';
import SearchBar from './components/SearchBar.vue';

export default {
  components: { SearchBar, RecipeForm, RecipeList},
  data() {
    return {
      recipes: [], // Liste de toutes les recettes
      selectedRecipe: null, // Recette sélectionnée pour modification
      filter: '', // Texte utilisé pour filtrer les recettes
    };
  },
  computed: {
    // Retourne les recettes filtrées selon le champ 'ingrédients'
    filteredRecipes() {
      if (!this.filter) return this.recipes;
      return this.recipes.filter(r =>
        r.ingredients.toLowerCase().includes(this.filter.toLocaleLowerCase())
      );
    },
  },
  methods: {
    // Met à jour le filtre à chaque recherche
    handleSearch(value) {
      this.filter = value;
    },
    // Les méthodes createRecipe, updateRecipe, deleteReciê seront liées liées à l'API
  }
}



</script>


