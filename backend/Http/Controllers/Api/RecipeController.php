<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

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
            return Recipe::where('ingredients', 'LIKE', '%' . $ingredient . '%')->get();
        }
        // Sinon, on retourne toutes les recettes sans filtre
        return Recipe::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
