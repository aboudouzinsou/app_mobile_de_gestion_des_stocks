<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Vente
 * 
 * @property int $id_vente
 * @property string|null $numero_vente
 * @property int|null $caisse_id
 * @property int|null $client_id
 * @property int|null $exercice_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Vente extends Model
{
    use HasFactory;

    protected $table = 'ventes';

    protected $casts = [
        'caisse_id' => 'int',
        'client_id' => 'int',
        'exercice_id' => 'int'
    ];

    protected $fillable = [
        'numero_vente',
        'caisse_id',
        'client_id',
        'exercice_id'
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
            'numero_vente' => 'nullable|string|max:255',
            'caisse_id' => 'nullable|integer|exists:caisses,id',
            'client_id' => 'nullable|integer|exists:clients,id',
            'exercice_id' => 'nullable|integer|exists:exercices,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the caisse associated with the vente.
     */
    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }

    /**
     * Get the client associated with the vente.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the exercice associated with the vente.
     */
    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }

    /**
     * Get the lignesVente associated with the vente.
     */
    public function lignesVente()
    {
        return $this->hasMany(LigneVente::class);
    }
}