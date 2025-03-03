<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electeur extends Model
{
    use HasFactory;

    protected $table = 'electeurs'; // Assure-toi que le nom est correct

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'numero_carte',
        'adresse',
        'telephone',
    ];
}
