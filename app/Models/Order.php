<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string|null $comment
 */
class Order extends Model
{
    protected $guarded = ['id'];
}
