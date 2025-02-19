<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadLog extends Model
{
    use HasFactory;
    
    protected $fillable = ['filename', 'reason', 'user_ip', 'user_id', 'attempted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
