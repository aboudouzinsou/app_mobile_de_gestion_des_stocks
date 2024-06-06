<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Commande
 * 
 * @property int $id_commande
 * @property string $numero_commande
 * @property Carbon $date_emission
 * @property Carbon $date_limite_boncommande
 * @property Carbon $date_livraison
 * @property string $statut_commande
 * @property bool $livree
 * @property int $fournisseur_id
 * @property int $exercice_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Commande extends Model
{
    use HasFactory;

    protected $table = 'Commande';
    protected $primaryKey = 'id_commande';

    protected $casts = [
        'date_emission' => 'datetime',
        'date_limite_boncommande' => 'datetime',
        'date_livraison' => 'datetime',
        'livree' => 'bool'
    ];

    protected $fillable = [
        'numero_commande',
        'date_emission',
        'date_limite_boncommande',
        'date_livraison',
        'statut_commande',
        'livree',
        'fournisseur_id',
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
            'numero_commande' => 'required|string|max:255',
            'date_emission' => 'required|date',
            'date_limite_boncommande' => 'required|date',
            'date_livraison' => 'required|date',
            'statut_commande' => 'required|string|max:255',
            'livree' => 'required|boolean',
            'fournisseur_id' => 'required|integer|exists:fournisseurs,id',
            'exercice_id' => 'required|integer|exists:exercices,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the fournisseur that owns the commande.
     */
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    /**
     * Get the exercice that owns the commande.
     */
    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }

    /**
     * Get the lignesCommande for the commande.
     */
    public function lignesCommande()
    {
        return $this->hasMany(LigneCommande::class);
    }
}