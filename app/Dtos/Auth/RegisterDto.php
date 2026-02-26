<?php

namespace App\Dtos\Auth;

use App\Models\User;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Regex;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class RegisterDto extends Data
{
    public function __construct(
        #[Regex('/^[A-ZА-Я][a-zа-я]*$/u')]
        public string $name,
        #[Regex('/^[A-ZА-Я][a-zа-я]*$/u')]
        public string $lastName,
        #[Email, Unique(User::class)]
        public string $email,
        #[Unique(User::class), Regex('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/')]
        public string $phone,
        public string $gender,
        #[Confirmed, Min(8), Regex('/(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/')]
        public string $password,
        public bool   $terms,
    )
    {
    }

    public static function messages(): array
    {
        return [
            'email.unique' => 'Пользователь с такой эл. почтой уже есть.',
            'phone.unique' => 'Пользователь с таким номером телефона уже есть.',
        ];
    }
}
