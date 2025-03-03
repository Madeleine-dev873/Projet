<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectorUploadAttempt extends Model
{
    use HasFactory;

    protected $table = 'elector_upload_attempts'; // 🔹 Spécifie le bon nom de table

    protected $fillable = [
        'user_id',
        'file_name',
        'checksum',
        'ip_address',
        'status',
    ];
}
