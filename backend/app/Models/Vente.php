<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_vente',
        'caisse_id',
        'client_id'
    ] ;

    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function ligneVentes()
    {
        return $this->hasMany(LigneVente::class);
    }
    
    
}
