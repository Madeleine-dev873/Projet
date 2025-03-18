<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;

class CandidatController extends Controller
{
    public function index()
    {
        $candidats = Candidat::all();
        return view('candidats.index', compact('candidats'));
    }

    public function create()
    {
        return view('candidats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numeroCarteElecteur' => 'required|unique:candidats|max:20',
            'nom' => 'required|max:100',
            'prenom' => 'required|max:100',
            'dateNaissance' => 'required|date',
            'email' => 'required|email|max:100',
            'telephone' => 'required|max:20',
            'partiPolitique' => 'nullable|max:100',
            'slogan' => 'nullable',
            'couleursParti' => 'nullable|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'urlInfo' => 'nullable|url|max:255',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('candidats_photos', 'public');
        }

        Candidat::create($data);

        return redirect()->route('candidats.index')->with('success', 'Candidat enregistré avec succès.');
    }

    public function verifier(Request $request)
{
    $candidat = Candidat::where('numeroCarteElecteur', $request->carte)->first();

    if (!$candidat) {
        return response()->json(['status' => 'error', 'message' => 'Candidat non trouvé.']);
    }

    return response()->json([
        'status' => 'success',
        'nom' => $candidat->nom,
        'prenom' => $candidat->prenom,
        'date_naissance' => $candidat->date_naissance
    ]);
}

public function listeCandidats()
{
    $candidats = Candidat::all(); 
    return response()->json($candidats); 
}


}
