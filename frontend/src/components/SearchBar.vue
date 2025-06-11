<template>
    <!-- Champ de texte pour filtrer les recettes par ingrédient -->
    
    <v-text-field
    v-model="searchTerm" 
    label="Rechercher par ingrédient"
    @input="$emit('search', searchTerm)"
    append-icon="mdi-magnify"
    />
</template>

<script>
export default {
    data() {
        return {

            // Terme de recherche saisi par l'utilisateur
            searchTerm: '',
        };
    },
};

</script>