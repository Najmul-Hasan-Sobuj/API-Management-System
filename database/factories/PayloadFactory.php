<?php

namespace Database\Factories;

use App\Models\Endpoint;
use App\Models\Payload;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayloadFactory extends Factory
{
    protected $model = Payload::class;

    public function definition(): array
    {
        return [
            'endpoint_id' => Endpoint::factory(),
            'body' => [
                'key1' => $this->faker->word(),
                'key2' => $this->faker->sentence(),
                'key3' => $this->faker->numberBetween(1, 100),
            ],
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_by' => User::factory(),
            'updated_by' => null,
            'deleted_by' => null,
        ];
    }
} 