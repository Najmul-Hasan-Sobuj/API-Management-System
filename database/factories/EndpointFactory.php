<?php

namespace Database\Factories;

use App\Models\Collection;
use App\Models\Endpoint;
use App\Models\Group;
use App\Models\HttpMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EndpointFactory extends Factory
{
    protected $model = Endpoint::class;

    public function definition(): array
    {
        $method = HttpMethod::inRandomOrder()->first();
        
        return [
            'name' => $this->faker->words(3, true),
            'uri' => $this->faker->url(),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'group_id' => Group::factory(),
            'collection_id' => Collection::factory(),
            'method_id' => $method ? $method->id : HttpMethod::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'deleted_by' => null,
        ];
    }
} 