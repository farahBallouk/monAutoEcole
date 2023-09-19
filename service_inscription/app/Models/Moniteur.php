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
        'nom',
        'prenom', 
        'id_user',
        'telephone',
    
    ];
}
