<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class LigneReception
 * 
 * @property int $id_ligne_reception
 * @property int|null $quantite_recu
 * @property int|null $reception_id
 * @property int|null $produit_id
 * @property int|null $ligne_commande_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LigneReception extends Model
{
    use HasFactory;

    protected $table = 'LigneReception';
    protected $primaryKey = 'id_ligne_reception';

    protected $casts = [
        'quantite_recu' => 'int',
        'reception_id' => 'int',
        'produit_id' => 'int',
        'ligne_commande_id' => 'int'
    ];

    protected $fillable = [
        'quantite_recu',
        'produit_id',
        'reception_id',
        'ligne_commande_id'
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
            'quantite_recu' => 'nullable|integer|min:0',
            'reception_id' => 'nullable|exists:receptions,id',
            'produit_id' => 'nullable|exists:produits,id',
            'ligne_commande_id' => 'nullable|exists:ligne_commandes,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the reception that owns the ligneReception.
     */
    public function reception()
    {
        return $this->belongsTo(Reception::class);
    }

    /**
     * Get the produit that owns the ligneReception.
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * Get the ligneCommande that owns the ligneReception.
     */
    public function ligneCommande()
    {
        return $this->belongsTo(LigneCommande::class);
    }
}