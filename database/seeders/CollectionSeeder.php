<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $groups = Group::all();

        foreach ($groups as $group) {
            Collection::factory()
                ->count(3)
                ->create([
                    'group_id' => $group->id,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]);
        }
    }
} 