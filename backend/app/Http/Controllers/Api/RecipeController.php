<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{
    // Méthode du contrôleur pour récupérer les recettes
    public function index(Request $request)
    {
        // Récupère la valeur du paramètre 'ingredient' depuis l'URL (ex: /api/recipe?ingredient=poulet)
        $ingredient = $request->query('ingredient');

        // Si un ingredient est fourni dans la requête,on filtre les recettes conteant cet ingredient
        if ($ingredient) {
            // Requête SQL : SELECT $ FROm recipes WHERE ingredients LIKE '%poulet%'
            return Recipe::where('ingredient', 'LIKE', '%' . $ingredient . '%')->get();
        }
        // Sinon, on retourne toutes les recettes sans filtre
        return Recipe::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données de la requête .Adaptation de ces règels de validation à la structure de la table 'recipe'
            $validateData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'ingredient' => 'required|string',
            ]);

            // Création de la nouvelle recette dans la base de données

            $recipe = Recipe::create($validateData);

            // Optionnel : Enregistrer dans leslogs de laravel

            Log::info('Nouvelle recette créée', ['recipe_id' => $recipe->id, 'title' => $recipe->title]);

            // Retourner la recette créée avec un statut 201 (Created)

            return response()->json($recipe, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Si la validation échoue, Laravel retourne automatiquement un 422 Unprocessable Entity.Ajout d'un log pour voir les erreurs de validation côté backend
            Log::error('Erreur de validation lors de la création de la recette', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422); // Laravel le fait déjà, mais explicite
        } catch (\Exception $e) {
            // Gérer d'autres erreurs inattendues (ex: problème de base de données)
            Log::error('Erreur inattendue lors de la création de la recette', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Une erreur est survenur lors de la création de la recette.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
