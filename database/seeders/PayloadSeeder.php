<?php

namespace Database\Seeders;

use App\Models\Endpoint;
use App\Models\Payload;
use App\Models\User;
use Illuminate\Database\Seeder;

class PayloadSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $endpoints = Endpoint::all();

        foreach ($endpoints as $endpoint) {
            Payload::factory()
                ->count(2)
                ->create([
                    'endpoint_id' => $endpoint->id,
                    'created_by' => $user->id,
                ]);
        }
    }
} 