<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        Group::factory()
            ->count(3)
            ->create([
                'user_id' => $user->id,
                'created_by' => $user->id,
            ]);
    }
} 