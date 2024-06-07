<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Personnel
 * 
 * @property int $id_personnel
 * @property string|null $code_personnel
 * @property string|null $nom_personnel
 * @property string|null $sexe
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Personnel extends Model
{
    use HasFactory;

    protected $table = 'personnels';    

    protected $fillable = [
        'code_personnel',
        'nom_personnel',
        'sexe'
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
            'code_personnel' => 'nullable|string|max:255',
            'nom_personnel' => 'nullable|string|max:255',
            'sexe' => 'nullable|string|in:male,female,other',  // Assuming sexe can be 'male', 'female', or 'other'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get the caisse associated with the personnel.
     */
    public function caisse()
    {
        return $this->hasOne(Caisse::class);
    }

    /**
     * Get the user associated with the personnel.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}