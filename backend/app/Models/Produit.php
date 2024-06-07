<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Produit
 * 
 * @property int $id_produit
 * @property string|null $code
 * @property string|null $libelle
 * @property float|null $prix
 * @property int|null $id_categorie
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits';    

    protected $casts = [
        'prix' => 'float',
        'id_categorie' => 'int'
    ];

    protected $fillable = [
        'code',
        'libelle',
        'prix',
        'id_categorie'
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
            'code' => 'nullable|string|max:255',
            'libelle' => 'nullable|string|max:255',
            'prix' => 'nullable|numeric|min:0',
            'id_categorie' => 'nullable|integer|exists:categories,id', // Assuming 'categories' is the table name for Categorie model
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the categorie associated with the produit.
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    /**
     * Get the lignes vente associated with the produit.
     */
    public function lignesVente()
    {
        return $this->hasMany(LigneVente::class);
    }

    /**
     * Get the lignes inventaire associated with the produit.
     */
    public function lignesInventaire()
    {
        return $this->hasMany(LigneInventaire::class);
    }

    /**
     * Get the stocker record associated with the produit.
     */
    public function stocker()
    {
        return $this->hasOne(Stocker::class);
    } 
}