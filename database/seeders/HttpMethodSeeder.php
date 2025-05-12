<?php

namespace Database\Seeders;

use App\Models\HttpMethod;
use Illuminate\Database\Seeder;

class HttpMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];
        
        foreach ($methods as $method) {
            HttpMethod::create([
                'method' => $method
            ]);
        }
    }
} 