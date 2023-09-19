<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moniteur extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_moniteur';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id_moniteur',
        'id_user',
        'nom',
        'prenom', 
        'telephone',
        'autoEcole_id',
    
    ];
    
    public function callendrierMoniteurr(){
        return $this->hasMany(Calendrier::class);

    }
    // public function autoecole(){
    //     return $this->belongsTo(AutoEcole::class);
    // }

}
