<template>
    <!--  liste des recettes avec actions modifier/supprimer -->
    <div>
        <!-- Boucle sur chaque recette pour l'afficher dans une carte'-->
        <v-card v-for="recipe in recipes" :key="recipe.id" class="mb-3">

            <!-- Titre de la recette -->
            <v-card-title>{{ recipe.title }}</v-card-title>

            <!-- Contenu de la carte : description et ingrédients-->
            <v-card-text>
                <div><strong>Description :</strong> {{ recipe.description }}</div>
                <div><strong>Ingredients :</strong> {{ recipe.ingredient }}</div>
            </v-card-text>

            <!-- Action possible : modifer ou supprimer la recette -->
            <v-card-actions>

                <!-- Bouton pour émettre un événement 'edit' vers le parent avec l'objet recette -->
                <v-btn color="primary" @click="$emit('edit', recipe)">Modifier</v-btn>

                <!-- Bouton pour émettre un événement 'delete' vers le parent avec l'ID de la recette -->
                <v-btn color="error" @click="$emit('delete', recipe.id)">Supprimer</v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    // Déclaration de la prop 'recipe' attendue depuis le parent
    props: {
        recipes: Array,
    },
};
</script>