<?php

namespace Database\Factories;

use App\Models\Endpoint;
use App\Models\Header;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HeaderFactory extends Factory
{
    protected $model = Header::class;

    public function definition(): array
    {
        return [
            'endpoint_id' => Endpoint::factory(),
            'key' => $this->faker->word(),
            'value' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_by' => User::factory(),
            'updated_by' => null,
            'deleted_by' => null,
        ];
    }
} 