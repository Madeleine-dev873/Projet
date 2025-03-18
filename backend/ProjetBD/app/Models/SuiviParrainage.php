<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parrainage; // Assurez-vous que ce modèle existe

class SuiviParrainageController extends Controller
{
    /**
     * Afficher la page de suivi des parrainages.
     */
    public function index()
    {
        $parrainages = Parrainage::all(); // Récupérer tous les parrainages
        return view('suivi-parrainage', compact('parrainages'));
    }
}
