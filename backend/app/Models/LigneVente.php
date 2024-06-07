<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class LigneVente
 * 
 * @property int $id_ligne_vente
 * @property int|null $quantite_vendu
 * @property int|null $vente_id
 * @property int|null $produit_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LigneVente extends Model
{
    use HasFactory;

    protected $table = 'ligne_ventes';    

    protected $casts = [
        'quantite_vendu' => 'int',
        'vente_id' => 'int',
        'produit_id' => 'int'
    ];

    protected $fillable = [
        'quantite_vendu',
        'vente_id',
        'produit_id'
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
            'quantite_vendu' => 'nullable|integer|min:0',
            'vente_id' => 'nullable|exists:ventes,id',
            'produit_id' => 'nullable|exists:produits,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the vente that owns the ligneVente.
     */
    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }

    /**
     * Get the produit that owns the ligneVente.
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);        
    }
}