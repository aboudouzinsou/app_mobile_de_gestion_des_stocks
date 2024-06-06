<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class LigneCommande
 * 
 * @property int $id_ligne_commande
 * @property int|null $quantite_produit_commande
 * @property int|null $qte_livre
 * @property int|null $qte_restate
 * @property float|null $TVA
 * @property float|null $TTC
 * @property int|null $commande_id
 * @property int|null $produit_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LigneCommande extends Model
{
    use HasFactory;

    protected $table = 'LigneCommande';
    protected $primaryKey = 'id_ligne_commande';

    protected $casts = [
        'quantite_produit_commande' => 'int',
        'qte_livre' => 'int',
        'qte_restate' => 'int',
        'TVA' => 'float',
        'TTC' => 'float',
        'commande_id' => 'int',
        'produit_id' => 'int'
    ];

    protected $fillable = [
        'quantite_produit_commande',
        'qte_livre',
        'qte_restate',
        'TVA',
        'TTC',
        'commande_id',
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
            'quantite_produit_commande' => 'nullable|integer|min:0',
            'qte_livre' => 'nullable|integer|min:0',
            'qte_restate' => 'nullable|integer|min:0',
            'TVA' => 'nullable|numeric|min:0',
            'TTC' => 'nullable|numeric|min:0',
            'commande_id' => 'nullable|exists:commandes,id',
            'produit_id' => 'nullable|exists:produits,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the lignesReception for the ligneCommande.
     */
    public function lignesReception()
    {
        return $this->hasMany(LigneReception::class);
    }

    /**
     * Get the commande that owns the ligneCommande.
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    /**
     * Get the produit that owns the ligneCommande.
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}