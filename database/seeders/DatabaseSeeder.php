<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user first
       User::factory()->create([
            'name' => 'Najmul',
            'email' => 'najmul@gmail.com',
            'password' => Hash::make('111111111'),
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Pass the user to other seeders
        $this->call([
            RoleAndPermissionSeeder::class,
            HttpMethodSeeder::class,
            // GroupSeeder::class,
            // CollectionSeeder::class,
            // EndpointSeeder::class,
            // HeaderSeeder::class,
            // PayloadSeeder::class,
            SuperAdminSeeder::class,
            TemplateSeeder::class,
        ]);
    }
}
