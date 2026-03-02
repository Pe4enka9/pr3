<?php

namespace App\Dtos;

use App\Enums\TimeEnum;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Regex;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class CallbackDto extends Data
{
    public function __construct(
        #[Regex('/^[A-ZА-Я][a-zа-я]*$/u')]
        public string   $name,
        #[Regex('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/')]
        public string   $phone,
        public TimeEnum $time,
    )
    {
    }
}
