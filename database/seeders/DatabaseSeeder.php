<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            User::factory()->create([
                'name' => 'Fabio Cruz',
                'email' => 'fabio.cruz@gmail.com',
                'password' => Hash::make('password')
            ]),
            PaymentType::class,
        ]);
    }
}
