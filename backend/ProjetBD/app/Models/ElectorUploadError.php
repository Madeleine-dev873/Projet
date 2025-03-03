<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectorUploadError extends Model
{
    use HasFactory;

    protected $table = 'elector_upload_errors'; // 🔹 Spécifie le bon nom de la table

    protected $fillable = [
        'upload_attempt_id',
        'error_message',
    ];

    // Relation avec ElectorUploadAttempt
    public function attempt()
    {
        return $this->belongsTo(ElectorUploadAttempt::class, 'upload_attempt_id');
    }
}
