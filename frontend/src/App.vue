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

      <!-- Liste des recettes filtrées avec actions éditer et supprimer -->
      <RecipeList
      :recipes="filteredRecipes"
      @edit="selectedRecipe = $event"
      @delete="deleteRecipe" 
      />

      <!-- Ce sont ces méthodes createRecipe, updateRecipe, deleteRecipe qui appellent Axios vers Laravel.-->

    </v-container>
  </v-app>
  
</template>

<script>
// Import duclient API configuré avec axios
import api from './services/api';
// Import des composant enfants
import RecipeForm from './components/RecipeForm.vue';
import RecipeList from './components/RecipeList.vue';
import SearchBar from './components/SearchBar.vue';

export default {
  components: { SearchBar, RecipeForm, RecipeList},
  data() {
    return {
      recipes: [], // Stocke toutes les recettes récupérées depuis l'API
      selectedRecipe: null, // Recette sélectionnée pour édition
      filter: '', // Texte de filtre pour la recherche d'ingrédients'
    };
  },
  computed: {
    // Renvoie les recttes filtrées en fonction du texte recherché dans les ingrédients
    filteredRecipes() {
      if (!this.filter) return this.recipes;
      return this.recipes.filter(r =>
        r.ingredient.toLowerCase().includes(this.filter.toLocaleLowerCase())
      );
    },
  },
  // Dès que le composant est créé,on charge les recettes depuis l'API
  created() {
    this.fetchRecipes();
  },
  methods: {
    // Récupère la liste des recettes depuis le backend
    async fetchRecipes() {
      try {
        const url = this.filter
        ? `/recipes?ingredient=${encodeURIComponent(this.filter)}`
        : '/recipes';

        const res = await api.get(url);
        this.recipes = res.data; // On met à jour la liste locale avec les données reçues
      } catch (err) {
        console.error('Erreur lors du chargement des recettes', err);
      }
    },

    // Crée une nouvelle recette en envoyant les données au backend
    async createRecipe(newRecipe) {
      try {
        await api.post('/recipes', newRecipe);
        this.fetchRecipes(); // Recharge la liste pour afficher la nouvelle recette
        this.$toast.success('Recette ajoutée !')
      } catch (err) {
        this.$toast.error('Erreur pour ajouter la recette')
        console.error('Erreur lors de la création', err);
      }
    },

    // Met à jour une recette existante via son ID
    async updateRecipe(updatedRecipe) {
      try {
        await api.put(`/recipes/${updatedRecipe.id}`, updatedRecipe);
        this.selectedRecipe = null; // On vide la recette sélectionnée (fin édition)
        this.fetchRecipes(); // Recharge la liste pour afficher la mise à jour
      } catch (err) {
        console.error('Erreur lors de la modification', err);
      }
    },

    // Supprime une recette après confirmation
    async deleteRecipe(id) {
      if (!confirm('Supprimer cette recette ?')) return; // Annule si non confirmé
      try {
        await api.delete(`/recipes/${id}`);
        this.fetchRecipes(); // Recharge la liste après suppression
      } catch (err) {
        console.error('Erreur lors de la suppression', err);
      }
    },
    // Met à jour le filtre de recherche quand l'utilisateur tape dans la barrede recherche'
    handleSearch(value) {
      this.filter = value;
      this.fetchRecipes(); // nouvelle requête filtrée
    },
  },
};



</script>


