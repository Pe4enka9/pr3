<?php

namespace App\Models;

use App\Enums\TimeEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $phone
 * @property TimeEnum $time
 */
class Callback extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'time' => TimeEnum::class,
    ];
}
