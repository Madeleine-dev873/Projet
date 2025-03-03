<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ElectorUploadController extends Controller
{
    public function uploadElectors(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
            'checksum' => 'required|string',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('electors_temp');

        // Vérification de l'empreinte SHA256
        $fileContent = file_get_contents($file->path());
        $calculatedChecksum = hash('sha256', $fileContent);

        if ($calculatedChecksum !== $request->checksum) {
            DB::table('elector_upload_attempts')->insert([
                'user_id' => Auth::id(),
                'file_name' => $file->getClientOriginalName(),
                'file_hash' => $request->checksum,
                'ip_address' => $request->ip(),
                'status' => false,
                'created_at' => now(),
            ]);

            return redirect()->back()->with('error', 'Empreinte SHA256 invalide.');
        }

        // Lecture du fichier CSV
        $handle = fopen(storage_path("app/" . $filePath), "r");
        $errors = [];
        $attemptId = DB::table('elector_upload_attempts')->insertGetId([
            'user_id' => Auth::id(),
            'file_name' => $file->getClientOriginalName(),
            'checksum' => $request->checksum,
            'ip_address' => $request->ip(),
            'status' => true,
            'created_at' => now(),
        ]);

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            [$cin, $numeroElecteur, $nom, $prenom, $dateNaissance, $lieuNaissance, $sexe] = $data;

            // Vérification des champs
            if (!preg_match('/^\d{12}$/', $cin) || !preg_match('/^\d{8}$/', $numeroElecteur)) {
                $errors[] = [
                    'upload_attempt_id' => $attemptId,
                    'cin' => $cin,
                    'numero_electeur' => $numeroElecteur,
                    'error_message' => 'Format CIN ou numéro électeur invalide',
                ];
                continue;
            }

            // Vérification des caractères spéciaux et accents
            if (!mb_check_encoding($nom, 'UTF-8') || !mb_check_encoding($prenom, 'UTF-8')) {
                $errors[] = [
                    'upload_attempt_id' => $attemptId,
                    'cin' => $cin,
                    'numero_electeur' => $numeroElecteur,
                    'error_message' => 'Encodage invalide (UTF-8 requis)',
                ];
                continue;
            }

            // Ajout dans la table temporaire
            DB::table('electors_temporary')->insert([
                'cin' => $cin,
                'numero_electeur' => $numeroElecteur,
                'nom' => $nom,
                'prenom' => $prenom,
                'date_naissance' => $dateNaissance,
                'lieu_naissance' => $lieuNaissance,
                'sexe' => $sexe,
                'created_at' => now(),
            ]);
        }
        fclose($handle);

        // Enregistrer les erreurs détectées
        if (!empty($errors)) {
            DB::table('elector_upload_errors')->insert($errors);
            return redirect()->back()->with('error', 'Des erreurs ont été détectées, consultez le journal.');
        }

        return redirect()->back()->with('success', 'Fichier importé avec succès et prêt pour validation.');
    }

    public function validateImport()
    {
        // Vérifier s'il y a des erreurs
        if (DB::table('elector_upload_errors')->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de valider, des erreurs sont présentes.');
        }

        // Transférer les électeurs vers la table principale
        DB::table('electors')->insert(DB::table('electors_temporary')->get()->toArray());

        // Supprimer les données temporaires
        DB::table('electors_temporary')->truncate();

        return redirect()->back()->with('success', 'Importation validée avec succès.');
    }
}
