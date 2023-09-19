<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_candidat';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id_candidat',
        'CIN',
        'id_autoEcole', 
        'id_user',
        'nom',
        'prenom',
        'GSM',
        'Age',
        'categorie',
        'langue',
        'Besoin',
    ];
}
