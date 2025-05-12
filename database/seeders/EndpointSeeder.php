<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Endpoint;
use App\Models\Group;
use App\Models\HttpMethod;
use App\Models\User;
use Illuminate\Database\Seeder;

class EndpointSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $groups = Group::all();
        $collections = Collection::all();
        $methods = HttpMethod::all();

        foreach ($groups as $group) {
            foreach ($collections as $collection) {
                Endpoint::factory()
                    ->count(2)
                    ->create([
                        'group_id' => $group->id,
                        'collection_id' => $collection->id,
                        'method_id' => $methods->random()->id,
                        'created_by' => $user->id,
                        'updated_by' => $user->id,
                    ]);
            }
        }
    }
} 