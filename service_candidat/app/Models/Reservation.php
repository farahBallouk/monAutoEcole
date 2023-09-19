<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\AutoEcoleController;

class Reservation extends Model
{
    use HasFactory;
  

    protected $fillable = [
        'id_autoEcole',
        'id_candidat',
        'date',
        'duree',
        'status',
    ];

    // public function autoEcole()
    // {
    //     return $this->belongsTo(AutoEcole::class, 'id_autoEcole');
    // }

    // public function candidat()
    // {
    //     return $this->belongsTo(Candidat::class, 'id_candidat');
    // }
}


