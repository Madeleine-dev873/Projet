<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    // Méthode pour uploader un fichier et valider son empreinte SHA256
    public function uploadFile(Request $request)
    {
        // Validation du fichier
        $request->validate([
            'document' => 'required|file|mimes:csv,txt|max:2048' // Accepte CSV & TXT, max 2MB
        ]);

        $file = $request->file('document');

        // Calcul de l'empreinte SHA256 du fichier téléchargé
        $fileChecksum = hash_file('sha256', $file->getRealPath());

        // Récupérer l'empreinte fournie par l'utilisateur
        $providedChecksum = $request->input('checksum');

        // Comparer l'empreinte calculée avec celle fournie par l'utilisateur
        if ($fileChecksum !== $providedChecksum) {
            return back()->with('error', 'L\'empreinte SHA256 du fichier ne correspond pas à celle fournie.');
        }

        // Vérification du fichier
        if (!$file->isValid()) {
            UploadLog::create([
                'filename' => $file->getClientOriginalName(),
                'reason' => 'Fichier corrompu ou invalide',
                'user_ip' => $request->ip(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', 'Le fichier est corrompu ou invalide.');
        }

        // Enregistrer le fichier dans storage/app/uploads
        $filePath = $file->store('uploads');

        // Log dans la table UploadLog
        UploadLog::create([
            'filename' => $file->getClientOriginalName(),
            'reason' => 'Fichier valide et checksum vérifié',
            'user_ip' => $request->ip(),
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Fichier uploadé avec succès et checksum validé !');
    }

    // Méthode pour afficher le formulaire de téléchargement
    public function showUploadForm()
    {
        // Récupérer les logs d'upload
        $logs = UploadLog::all();
    
        // Passer les logs à la vue
        return view('upload', compact('logs'));
    }

    // Méthode pour importer un fichier CSV dans la base de données
    public function importCSV(Request $request)
    {
        // Validation du fichier CSV
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        // Récupérer le fichier CSV
        $file = $request->file('csv_file');

        // Lire le fichier CSV
        $filePath = $file->storeAs('uploads', $file->getClientOriginalName());
        $csvData = array_map('str_getcsv', file(Storage::path($filePath)));

        // Enregistrer chaque ligne du CSV dans la base de données
        foreach ($csvData as $row) {
            // Ajuster l'index des champs en fonction de votre structure CSV
            UploadLog::create([
                'filename' => $row[0],
                'reason' => $row[1],
                'user_ip' => $row[2],
                'attempted_at' => $row[3],
            ]);
        }

        return back()->with('success', 'CSV importé avec succès.');
    }
}
