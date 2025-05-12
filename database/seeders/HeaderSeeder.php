<?php

namespace Database\Seeders;

use App\Models\Endpoint;
use App\Models\Header;
use App\Models\User;
use Illuminate\Database\Seeder;

class HeaderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $endpoints = Endpoint::all();

        foreach ($endpoints as $endpoint) {
            Header::factory()
                ->count(2)
                ->create([
                    'endpoint_id' => $endpoint->id,
                    'created_by' => $user->id,
                ]);
        }
    }
} 