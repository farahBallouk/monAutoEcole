<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'id_candidat',
        'autoEcole_id',
        'date',
        'type',
        'result',
      
    ];

}

