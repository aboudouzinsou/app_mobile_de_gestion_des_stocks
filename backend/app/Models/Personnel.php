<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'user_id'
    ] ;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function caisse()
    {
        return $this->hasOne(Caisse::class);
    }
}
