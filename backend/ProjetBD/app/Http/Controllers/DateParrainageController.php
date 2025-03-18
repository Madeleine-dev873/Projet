<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DateParrainage;

class DateParrainageController extends Controller
{
    public function updateDates(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        // Vérifier s'il existe déjà une entrée et la mettre à jour
        $dateParrainage = DateParrainage::first();
        if ($dateParrainage) {
            $dateParrainage->update([
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin
            ]);
        } else {
            // Créer une nouvelle entrée si elle n'existe pas
            DateParrainage::create([
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin
            ]);
        }

        return redirect()->back()->with('success', 'Période mise à jour avec succès.');
    }
}
