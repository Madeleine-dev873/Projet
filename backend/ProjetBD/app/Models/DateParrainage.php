<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateParrainage extends Model
{
    use HasFactory;

    protected $table = 'dates';
    protected $fillable = ['date_debut', 'date_fin'];
}
