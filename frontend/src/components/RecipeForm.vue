<template>

    <!-- formulaire de création ou modification de recette -->
    <v-form @submit.prevent="submitForm">

    <!-- Champ pour le titre de la recette -->    
    <v-text-field v-model="form.title" label="Titre" required />

    <!-- Zone de texte pour la description de la recette  -->
    <v-textarea v-model="form.description" label="Description" rows="3" />

    <!-- Zone de texte pour les ingrédients (séparés par des virgules) -->
    <v-textarea v-model="form.ingredient" label="Ingrédients (séparés par des virgules)" rows="3" />

    <!-- Bouton de soummision (ajouter ou modifier selon le mode) -->
    <v-btn type="submit" color="primary" class="mr-2">{{ isEdit ? 'Modifier' : 'Ajouter' }}</v-btn>

    <!-- Bouton pour réinitialiser le formulaire (annuler l'edition) -->
    <v-btn text @click="resetForm">Annuler</v-btn>

    </v-form>

</template>

<script>

export default {
    props: {
        // Donnée reçues depuis le parent (une recette existante à modifier)
        editData: Object,
    },
    data() {
        return {
            // Etat local du formulaire (titre, description, ingrédients)
            form: {
                title: '',
                description: '',
                ingredient: '',
            },
        };
    },
    computed: {
        // Indique si on est en mode édition (si editData est fourni)
        isEdit() {
            return !!this.editData;
        },
    },
    watch: {
        // Met à jour le formaulaire si editData (ex: nouvelle recette à editer)
        editData(newVal) {
            if (newVal) {
                this.form = { ...newVal, ingredient: newVal.ingredient || '' }; // S'assurer que 'ingredient' est bien pris en compte lors de l'édition
            }
        },
    },
    methods: {
        // Emet un événement vers le parent pour ajouter ou modifier la recette
        submitForm() {
            this.$emit(this.isEdit ? 'update-recipe' : 'create-recipe', { ...this.form });
            this.resetForm();
        },
        // Réinitialise les champs du formulaire et émet un événement pour annuler l'édition'
        resetForm() {
            this.form = { title: '', description: '', ingredient: ''};
            this.$emit('cancel-edit');
        },
    },
};

</script>