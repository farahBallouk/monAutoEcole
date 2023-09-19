<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoEcole extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_autoEcole';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_autoEcole', 
        'id_user',
        'nom',
        'telephone',
        'adresse',
        'logo',
        'Type_abonnement',
        'info_fiscales',
        'localisation',
        'social',

    ];
}
