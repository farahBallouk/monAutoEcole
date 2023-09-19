<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_vehicule', 
        'model',
        'marque',
        'couleur',
        'id_autoEcole',
    ];

    public function callendrierVehicule(){
        return $this->hasMany(Calendrier::class);

    }
    public function autoecole(){
        return $this->belongsTo(AutoEcole::class);
    }

}
