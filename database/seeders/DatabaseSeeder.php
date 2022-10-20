<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        // \App\Models\UserMiddleware::factory(10)->create();

        // \App\Models\UserMiddleware::factory()->create([
        //     'name' => 'Test UserMiddleware',
        //     'email' => 'test@example.com',
        // ]);
    }
}
