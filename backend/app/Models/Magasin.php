<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Magasin
 * 
 * @property int $id_magasin
 * @property string|null $code
 * @property string|null $libelle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Magasin extends Model
{
    use HasFactory;

    protected $table = 'Magasin';
    protected $primaryKey = 'id_magasin';

    protected $fillable = [
        'code',
        'libelle'
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
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the receptions for the magasin.
     */
    public function receptions()
    {
        return $this->hasMany(Reception::class);
    }

    /**
     * Get the produits for the magasin.
     */
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    /**
     * Get the stockers for the magasin.
     */
    public function stockers()
    {
        return $this->hasMany(Stocker::class);
    }

    /**
     * Get the inventaires for the magasin.
     */
    public function inventaires()
    {
        return $this->hasMany(Inventaire::class);
    }
}