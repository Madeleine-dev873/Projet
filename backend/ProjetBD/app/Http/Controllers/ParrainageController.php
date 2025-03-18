<?php
namespace App\Http\Controllers;

use App\Models\Parrainage;
use App\Models\Candidat;
use Illuminate\Http\Request;

class ParrainageController extends Controller
{
    // Afficher le formulaire de parrainage pour un candidat donné
    public function parrainer($candidatId)
    {
        $candidat = Candidat::findOrFail($candidatId);
        return view('parrainages.create', compact('candidat'));
    }

    // Enregistrer un nouveau parrainage
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'candidat_id' => 'required|exists:candidats,id',
            'electeur_id' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:parrainages,email',
        ]);

        // Création du parrainage
        Parrainage::create([
            'candidat_id' => $request->candidat_id,
            'electeur_id' => $request->nom,
            '' => $request->prenom,
            'email' => $request->email,
        ]);

        // Redirection avec un message de succès
        return redirect()->route('parrainages.create', ['candidat' => $request->candidat_id])
                         ->with('success', 'Parrainage soumis avec succès!');
    }
    public function index()
    {
        // Logique pour afficher la liste des parrainages
    }

}
