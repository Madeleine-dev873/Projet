<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Electeur;
use App\Models\DateParrainage;

class ElecteurController extends Controller
{
    public function create()
    {
        // Vérifier si la date de parrainage est valide
        $date = DateParrainage::first();
        if (!$date || now()->lt($date->date_debut) || now()->gt($date->date_fin)) {
            return redirect()->back()->with('error', 'La période de parrainage n\'est pas encore ouverte ou est déjà terminée.');
        }

        return view('inscription');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        // Validation des champs
        try{
            $validatedData = $request->validate([
                'numero_carte_electeur' => 'required|unique:electeurs,numero_carte_electeur',
                'numero_carte_identite' => 'required|unique:electeurs,numero_carte_identite',
                'nom' => 'required',
                'prenom' => 'required',
                'date_naissance' => 'required|date',
                'adresse' => 'required|string',
                'bureau_vote' => 'required',
                'telephone' => 'required|unique:electeurs,telephone',
                'email' => 'required|email|unique:electeurs,email',
            ]);
            Electeur::create($validatedData);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
        return redirect()->route('choisir.role')->with('success', 'Inscription réussie. Vérifiez votre email et téléphone pour le code.');
    }
}
