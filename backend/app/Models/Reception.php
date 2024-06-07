<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Reception
 * 
 * @property int $id_reception
 * @property string|null $numero_reception
 * @property Carbon|null $date_reception
 * @property int|null $id_commande
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Reception extends Model
{
    use HasFactory;

    protected $table = 'receptions';    

    protected $casts = [
        'date_reception' => 'datetime',
        'commande_id' => 'int'
    ];

    protected $fillable = [
        'numero_reception',
        'date_reception',
        'commande_id',
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
            'numero_reception' => 'nullable|string|max:255',
            'date_reception' => 'nullable|date',
            'commande_id' => 'nullable|integer|exists:commandes,id', // Assuming 'commandes' is the table name for Commande model
            'exercice_id' => 'nullable|integer|exists:exercices,id', // Assuming 'exercices' is the table name for Exercice model
            'magasin_id' => 'nullable|integer|exists:magasins,id', // Assuming 'magasins' is the table name for Magasin model
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the exercice associated with the reception.
     */
    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }

    /**
     * Get the magasin associated with the reception.
     */
    public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }

    /**
     * Get the lignes reception associated with the reception.
     */
    public function lignesReception()
    {
        return $this->hasMany(LigneReception::class);
    }
}