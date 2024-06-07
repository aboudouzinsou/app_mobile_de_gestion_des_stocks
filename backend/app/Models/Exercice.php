<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Exercice
 * 
 * @property int $id_exercice
 * @property string|null $code_exercice
 * @property Carbon|null $date_debut
 * @property Carbon|null $date_fin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Exercice extends Model
{
    use HasFactory;

    protected $table = 'exercices';    

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime'
    ];

    protected $fillable = [
        'code_exercice',
        'date_debut',
        'date_fin'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->validate();
        });
    }

    /**
     * Validate the model's attributes.
     *
     * @throws ValidationException
     */
    public function validate()
    {
        $validator = Validator::make($this->attributes, [
            'code_exercice' => 'nullable|string|max:255',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the ventes for the exercice.
     */
    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }

    /**
     * Get the commandes for the exercice.
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    /**
     * Get the reception for the exercice.
     */
    public function reception()
    {
        return $this->hasMany(Reception::class);
    }

    /**
     * Get the inventaire for the exercice.
     */
    public function inventaire()
    {
        return $this->hasMany(Inventaire::class);
    }
}