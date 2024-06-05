<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneVente extends Model
{
    use HasFactory;

    protected $fillable = [
        'vente_id',
        'quantite_vendue'
    ];

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }
}
