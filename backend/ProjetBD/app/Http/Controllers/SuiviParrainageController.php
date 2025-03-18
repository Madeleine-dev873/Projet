<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidat;



    class SuiviParrainageController extends Controller
{
    public function index()
    {
        // Récupérer tous les candidats à parrainer depuis la base de données
        $candidats = Candidat::all(); // Ou ajuster selon ta logique (par exemple, si tu veux filtrer les candidats)

        // Passer la variable $candidats à la vue
        return view('suivi-parrainage', compact('candidats'));
    }
    }



