<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'libelle',
    ];

   public function personnel()
   {
    return $this->belongsTo(Personnel::class);
   }

   public function ventes()
   {
    return $this->hasMany(Vente::class);
   }
}
