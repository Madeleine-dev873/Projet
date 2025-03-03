<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Electeur;

class ElecteurController extends Controller
{
    public function registerElecteur(Request $request)
    {
        $request->validate([
            'numero_carte_electeur' => 'required|unique:candidats',
            'nom' => 'required',
            'prenom' => 'required',
            'date_naissance' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
        ]);

        $candidat = Electeur::create($request->all());

        // Envoyer un code de sécurité par email et SMS
        // (Utiliser un service comme Twilio ou Mailgun)

        return response()->json(['message' => 'Electeur enregistré avec succès.'], 201);
    }
    public function index()
    {
        // On récupère les électeurs avec pagination (10 par page par exemple)
        $electeurs = Electeur::paginate(10);
        return view('electeurs.index', compact('electeurs'));
    }
}