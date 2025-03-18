<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Electeur;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ImportElecteurs extends Command
{
    protected $signature = 'import:electeurs {file}';
    protected $description = 'Importer les électeurs depuis un fichier CSV';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("Le fichier n'existe pas.");
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0); // Utiliser la première ligne comme en-têtes

        DB::beginTransaction();
        try {
            foreach ($csv as $record) {
                Electeur::updateOrCreate(
                    ['numero_carte_electeur' => $record['numero_carte']],
                    [
                        'nom' => $record['nom'],
                        'prenom' => $record['prenom'],
                        'date_naissance' => $record['date_naissance'],
                        'adresse' => $record['adresse'],
                        'telephone' => $record['telephone'],
                        'numero_carte_identite' => null, // À remplir plus tard
                        'bureau_vote' => null, // À remplir plus tard
                        'email' => null, // À remplir plus tard
                    ]
                );
            }
            DB::commit();
            $this->info("Importation réussie !");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Erreur lors de l'importation : " . $e->getMessage());
        }
    }
}
