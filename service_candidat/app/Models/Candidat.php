<?php

namespace App\Models;
use App\Models\AutoEcole;

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
        'cin',
        'id_user',
        'autoEcole_id', 
        'nom',
        'prenom',
        'gsm',
        'adresse',
        'age',
        'categorie',
        'langue',
        'besoin',
    ];
    public function autoEcole()
    {
        return $this->belongsTo(AutoEcole::class, 'autoEcole_id');
    }
}
