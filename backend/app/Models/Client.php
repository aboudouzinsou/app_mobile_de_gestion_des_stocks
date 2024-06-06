<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Client
 * 
 * @property int $id_client
 * @property string $nom_client
 * @property string $prenom_client
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Client extends Model
{
    use HasFactory;

    protected $table = 'Client';
    protected $primaryKey = 'id_client';

    protected $fillable = [
        'nom_client',
        'prenom_client'
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
            'nom_client' => 'required|string|max:255',
            'prenom_client' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the ventes for the client.
     */
    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }
}