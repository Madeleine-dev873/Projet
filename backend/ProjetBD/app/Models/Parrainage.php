<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parrainage extends Model
{
    use HasFactory;

    // Spécifier les colonnes qui sont mass assignable
    protected $fillable = [
        'candidat_id', 'nom', 'prenom', 'email'
    ];

    // Définir la relation avec le candidat (si nécessaire, selon le modèle Candidat)
    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'candidat_id');
    }
}
