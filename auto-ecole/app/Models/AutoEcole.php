<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoEcole extends Model
{

    use HasFactory;
    protected $primaryKey = 'autoEcole_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'autoEcole_id', 
        'nom',
        'id_user',
        'telephone',
        'adresse',
        'logo',
        'Type_abonnement',
        'info_fiscales',
        'localisation',
        'social',
        

    ];
    protected $casts = [
        'social' => 'json',
    ];

    public function autoecolegalleries(){
        return $this->hasMany(AutoEcoleGallery::class);

    }
    public function callendrierautoEcole(){
        return $this->hasMany(Calendrier::class);

    }
    public function moniteurautoEcole(){
        return $this->hasMany(Moniteur::class);

    }
    public function vehiculeautoEcole(){
        return $this->hasMany(Vehicule::class);

    }
}
