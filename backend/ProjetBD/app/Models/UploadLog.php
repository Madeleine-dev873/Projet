<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadLog extends Model
{
    use HasFactory;

    public $timestamps = true; 

    // Utiliser le nom exact de la table dans la base de données
    protected $table = 'uploads_logs';

    protected $fillable = ['filename', 'reason', 'user_ip', 'user_id'];
}
