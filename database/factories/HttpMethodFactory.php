<?php

namespace Database\Factories;

use App\Models\HttpMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class HttpMethodFactory extends Factory
{
    protected $model = HttpMethod::class;

    public function definition(): array
    {
        return [
            'method' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']),
        ];
    }
} 