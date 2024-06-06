<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class LigneInventaire
 * 
 * @property int $id_ligne_inventaire
 * @property int|null $qte_produit_inv
 * @property int|null $inventaire_id
 * @property int|null $produit_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LigneInventaire extends Model
{
    use HasFactory;

    protected $table = 'LigneInventaire';
    protected $primaryKey = 'id_ligne_inventaire';

    protected $casts = [
        'qte_produit_inv' => 'int',
        'inventaire_id' => 'int',
        'produit_id' => 'int'
    ];

    protected $fillable = [
        'qte_produit_inv',
        'inventaire_id',
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
            'qte_produit_inv' => 'nullable|integer|min:0',
            'inventaire_id' => 'nullable|exists:inventaires,id',
            'produit_id' => 'nullable|exists:produits,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the inventaire that owns the ligneInventaire.
     */
    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class);
    }

    /**
     * Get the produit that owns the ligneInventaire.
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}