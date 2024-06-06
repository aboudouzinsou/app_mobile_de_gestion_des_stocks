<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Caisse
 * 
 * @property int $id_caisse
 * @property string $code
 * @property string $libelle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $personnel_id
 *
 * @package App\Models
 */
class Caisse extends Model
{
    use HasFactory;

    protected $table = 'Caisse';
    protected $primaryKey = 'id_caisse';

    protected $fillable = [
        'code',
        'libelle',
        'personnel_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'code' => '',
        'libelle' => '',
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
            'code' => 'required|string|max:255',
            'libelle' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the ventes for the caisse.
     */
    public function ventes()
    {
        return $this->hasMany(Vente::class); 
    }

    /**
     * Get the personnel that owns the caisse.
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}