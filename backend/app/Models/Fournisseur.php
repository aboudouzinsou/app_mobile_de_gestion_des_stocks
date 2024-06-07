<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Fournisseur
 * 
 * @property int $id_fournisseur
 * @property string|null $code_fournisseur
 * @property string|null $nom_fournisseur
 * @property string|null $adresse_fournisseur
 * @property string|null $telephone_fournisseur
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Fournisseur extends Model
{
    use HasFactory;

    protected $table = 'fournisseurs';   

    protected $fillable = [
        'code_fournisseur',
        'nom_fournisseur',
        'adresse_fournisseur',
        'telephone_fournisseur'
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
            'code_fournisseur' => 'nullable|string|max:255|unique:Fournisseur,code_fournisseur,' . $this->id_fournisseur . ',id_fournisseur',
            'nom_fournisseur' => 'nullable|string|max:255',
            'adresse_fournisseur' => 'nullable|string|max:255',
            'telephone_fournisseur' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the commandes for the fournisseur.
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}