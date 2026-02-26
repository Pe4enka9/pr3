<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $gender_id
 * @property string $password
 *
 * @property-read Gender $gender
 */
class User extends Authenticatable
{
    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }
}
