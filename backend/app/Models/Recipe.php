<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;

    // Permet de définir les colonnes autorirsées à être remplie via des formulaires ou des requêtes API

    protected $fillable = [
        'title',
        'description',
        'ingredient'
    ];
}
