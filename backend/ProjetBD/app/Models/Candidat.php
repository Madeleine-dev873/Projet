<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;

    protected $table = 'candidats'; 
    protected $primaryKey = 'idCandidat';
    public $timestamps = true;

    protected $fillable = [
        'numeroCarteElecteur',
        'nom',
        'prenom',
        'dateNaissance',
        'email',
        'telephone',
        'partiPolitique',
        'slogan',
        'couleursParti',
        'photo',
        'urlInfo',
    ];
}
