<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $personnel_id
 *
 * @package App\Models
 */
class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'personnel_id'
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

        static::creating(function ($model) {
            $model->hashPassword();
        });

        static::updating(function ($model) {
            if ($model->isDirty('password')) {
                $model->hashPassword();
            }
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->id,
            'password' => 'required|string|min:8',
            'personnel_id' => 'nullable|integer|exists:personnels,id', // Assuming 'personnels' is the table name for Personnel model
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Hash the user's password.
     */
    public function hashPassword()
    {
        if (!empty($this->password)) {
            $this->password = Hash::make($this->password);
        }
    }

    /**
     * Get the personnel associated with the user.
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}