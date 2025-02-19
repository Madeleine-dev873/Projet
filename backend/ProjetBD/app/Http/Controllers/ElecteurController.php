<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;

class CandidatController extends Controller
{
    public function registerCandidat(Request $request)
    {
        $request->validate([
            'numero_carte_electeur' => 'required|unique:candidats',
            'nom' => 'required',
            'prenom' => 'required',
            'date_naissance' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
        ]);

        $candidat = Candidat::create($request->all());

        // Envoyer un code de sécurité par email et SMS
        // (Utiliser un service comme Twilio ou Mailgun)

        return response()->json(['message' => 'Candidat enregistré avec succès.'], 201);
    }
}