<template>
<v-container class="my-8">
    <v-card class="pa-6" elevation="4" color="light-blue-lighten-5"> 
    <v-card-title class="text-h6 text-md-h5 text-center mb-4">
        {{ isEdit ? 'Modifier la Recette' : 'Ajouter une Nouvelle Recette' }}
    </v-card-title>

    

    <!-- Formulaire de création ou modification de recette -->
    <v-form @submit.prevent="submitForm">

        <!-- Champ pour le titre de la recette -->    
        <v-text-field
        v-model="form.title"
        label="Titre"
        variant="outlined"
        class="mb-4"
        required
        ></v-text-field>

        <!-- Zone de texte pour la description de la recette  -->
        <v-textarea
        v-model="form.description"
        label="Description"
        rows="3"
        variant="outlined"
        class="mb-4"
        ></v-textarea>

        <!-- Zone de texte pour les ingrédients (séparés par des virgules) -->
        <v-textarea
        v-model="form.ingredient"
        label="Ingrédients (séparés par des virgules)"
        rows="3"
        variant="outlined"
        class="mb-6"
        ></v-textarea>

        <!-- Boutons de soumission et d'annulation -->
        <v-row justify="center" class="mt-4">
        <v-col cols="auto">
            <v-btn
            type="submit"
            color="primary"
            size="large"
            class="mr-4"
            elevation="2"
            >
            {{ isEdit ? 'MODIFIER' : 'AJOUTER' }}
            </v-btn>
        </v-col>
        <v-col cols="auto">
            <v-btn
            color="grey-darken-1"
            variant="outlined"
            size="large"
            @click="resetForm"
            >
            ANNULER
            </v-btn>
        </v-col>
        </v-row>
    </v-form>
    </v-card>
</v-container>
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
                ingredient: '', // Confirmé au singulier pour la compatibilité backend
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
        // Met à jour le formulaire si editData change (par exemple, sélection d'une recette à éditer)
        editData(newVal) {
            if (newVal) {
                // Copie les données reçues, en s'assurant que 'ingredient' est bien pris en compte
                this.form = { ...newVal, ingredient: newVal.ingredient || '' };
            }
        },
    },
    methods: {
        // Émet un événement vers le parent pour ajouter ou modifier la recette
        submitForm() {
            // Utilise l'opérateur de propagation pour émettre une copie de l'objet 'form'
            this.$emit(this.isEdit ? 'update-recipe' : 'create-recipe', { ...this.form });
            this.resetForm(); // Réinitialise le formulaire après soumission
        },
        // Réinitialise les champs du formulaire et émet un événement pour annuler l'édition
        resetForm() {
            this.form = { title: '', description: '', ingredient: ''}; // Réinitialise les champs
            this.$emit('cancel-edit'); // Informe le parent que l'édition est annulée
        },
    },
};
</script>

<style scoped>
/* Vous pouvez ajouter des styles spécifiques à ce composant ici si nécessaire,
   mais Vuetify gère la majeure partie de l'apparence. */
</style>
