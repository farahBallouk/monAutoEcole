<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoEcoleGallery extends Model
{
    use HasFactory;
   

    public function autoecole(){
        return $this->belongsTo(AutoEcole::class);
    }
}
