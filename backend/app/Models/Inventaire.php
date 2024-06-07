<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Inventaire
 * 
 * @property int $id_inventaire
 * @property Carbon|null $date_inventaire
 * @property int $exercice_id
 * @property int $magasin_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Inventaire extends Model
{
    use HasFactory;

    protected $table = 'inventaires';    

    protected $casts = [
        'date_inventaire' => 'datetime'
    ];

    protected $fillable = [
        'date_inventaire',
        'exercice_id',
        'magasin_id'
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
            'date_inventaire' => 'nullable|date',
            'exercice_id' => 'required|exists:exercices,id',
            'magasin_id' => 'required|exists:magasins,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the exercice that owns the inventaire.
     */
    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }

    /**
     * Get the magasin that owns the inventaire.
     */
    public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }

    /**
     * Get the lignesInventaire for the inventaire.
     */
    public function lignesInventaire()
    {
        return $this->hasMany(LigneInventaire::class);
    }
}