<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendrier extends Model
{
    use HasFactory;
    
    protected $dates = [
        'start_date',
         'end_date',
    ];

    public function autoecole(){
        return $this->belongsTo(AutoEcole::class);
    }
    public function moniteur(){
        return $this->belongsTo(Moniteur::class);
    }
    public function vehicule(){
        return $this->belongsTo(Vehicule::class);
    }
}
