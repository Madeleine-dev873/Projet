<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\UploadLog;
use App\Models\Electeur;

class UploadController extends Controller
{
    // Méthode pour uploader un fichier et valider son empreinte SHA256
    public function uploadFile(Request $request)
    {
        // Validation du fichier
        $request->validate([
            'document' => 'required|file|mimes:csv,txt|max:2048'
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
                'reason'   => 'Fichier corrompu ou invalide',
                'user_ip'  => $request->ip(),
                'user_id'  => Auth::id(),
            ]);
            return back()->with('error', 'Le fichier est corrompu ou invalide.');
        }

        // Enregistrer le fichier dans storage/app/uploads
        $filePath = $file->store('uploads');

        // Log dans la table UploadLog
        UploadLog::create([
            'filename' => $file->getClientOriginalName(),
            'reason'   => 'Fichier valide et checksum vérifié',
            'user_ip'  => $request->ip(),
            'user_id'  => Auth::id(),
        ]);

        return back()->with('success', 'Fichier uploadé avec succès et checksum validé !');
    }

    // Méthode pour afficher le formulaire de téléchargement
    public function showUploadForm()
    {
        // Ici on récupère tous les logs (utilise UploadLog ou un autre modèle si nécessaire)
        $logs = UploadLog::all();

        return view('upload', compact('logs'));
    }

    // Méthode pour importer un fichier CSV dans la base de données
    public function importCSV(Request $request)
    {
        // Validation du fichier CSV
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        // Récupérer le fichier CSV et le stocker
        $file = $request->file('csv_file');
        $filePath = $file->storeAs('uploads', $file->getClientOriginalName());
        $fullPath = Storage::path($filePath);

        // Ouvrir le fichier pour lecture
        if (($handle = fopen($fullPath, 'r')) === false) {
            return back()->with('error', 'Impossible d\'ouvrir le fichier.');
        }

        $importCount = 0;
        $errors = [];

        // Supposons que la première ligne contient les en-têtes, on la saute
        $header = fgetcsv($handle, 1000, ',');

        // Lecture ligne par ligne du CSV
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            try {
                Electeur::create([
                    'nom'            => $data[0] ?? null,
                    'prenom'         => $data[1] ?? null,
                    'date_naissance' => $data[2] ?? null,
                    'numero_carte'   => $data[3] ?? null,
                    'adresse'        => $data[4] ?? null,
                    'telephone'      => $data[5] ?? null,
                ]);
                $importCount++;
            } catch (\Exception $e) {
                $errors[] = "Erreur pour la ligne : " . implode(',', $data) . " : " . $e->getMessage();
            }
        }
        fclose($handle);

        $message = "CSV importé avec succès. {$importCount} électeurs importés.";
        if (!empty($errors)) {
            $message .= " Certaines erreurs sont survenues lors de l'import.";
        }

        return back()->with('success', $message);
    }
}
