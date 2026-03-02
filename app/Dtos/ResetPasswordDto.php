<?php

namespace App\Dtos;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Regex;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ResetPasswordDto extends Data
{
    public function __construct(
        #[Confirmed, Min(8), Regex('/(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/')]
        public string $password,
    )
    {
    }
}
