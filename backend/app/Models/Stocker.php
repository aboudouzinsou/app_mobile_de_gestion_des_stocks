<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Stocker
 * 
 * @property int $id_stock
 * @property int|null $qte_stocke
 * @property int|null $dump
 * @property int|null $id_magasin
 * @property int|null $id_produit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Stocker extends Model
{
    use HasFactory;

    protected $table = 'stockers';   

    protected $casts = [
        'qte_stocke' => 'int',
        'dump' => 'int',
        'magasin_id' => 'int',
        'produit_id' => 'int'
    ];

    protected $fillable = [
        'qte_stocke',
        'dump',
        'magasin_id',
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
            'qte_stocke' => 'nullable|integer|min:0',
            'dump' => 'nullable|integer',
            'magasin_id' => 'nullable|integer|exists:magasins,id', // Assuming 'magasins' is the table name for Magasin model
            'produit_id' => 'nullable|integer|exists:produits,id', // Assuming 'produits' is the table name for Produit model
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the produit associated with the stocker.
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * Get the magasin associated with the stocker.
     */
    public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }
}