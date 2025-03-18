<?php
namespace App\Http\Auth\Controllers;
use Illuminate\Http\Request;
use App\Models\Parrainage;
use App\Models\Electeur;
use App\Models\Candidat;
use Illuminate\Support\Facades\Mail;
use App\Mail\ParrainageConfirmation;

class ParrainageController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'numero_electeur' => 'required|exists:electeurs,numero_electeur',
            'numero_cin' => 'required|exists:electeurs,numero_cin',
            'code_verification' => 'required|string'
        ]);

        $electeur = Electeur::where('numero_electeur', $request->numero_electeur)->first();
        $candidat = Candidat::find($request->candidat_id);

        // Vérification du code d'authentification
        if ($electeur->code_verification != $request->code_verification) {
            return response()->json(['error' => 'Code de vérification incorrect'], 400);
        }

        // Enregistrement du parrainage
        $parrainage = Parrainage::create([
            'electeur_id' => $electeur->id,
            'candidat_id' => $candidat->id,
            'code_verification' => $request->code_verification,
            'status' => 'enregistré'
        ]);

        // Envoi du code de confirmation par email et SMS
        Mail::to($electeur->email)->send(new ParrainageConfirmation($parrainage));

        return response()->json(['message' => 'Parrainage enregistré avec succès']);
    }

    public function showParrainages()
    {
        $parrainages = Parrainage::with('electeur', 'candidat')->get();
        return response()->json($parrainages);
    }
}
