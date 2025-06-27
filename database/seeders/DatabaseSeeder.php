<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Klant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@email.com',
            'password' => bcrypt('password'),
        ]);


        // 5 dummy klanten
        Klant::insert([
            [
                'naam' => 'Familie Jansen',
                'adres' => 'Dorpsstraat 1, 1234 AB Plaats',
                'telefoon' => '0612345678',
                'email' => 'jansen@email.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Familie De Vries',
                'adres' => 'Hoofdweg 10, 5678 CD Stad',
                'telefoon' => '0687654321',
                'email' => 'devries@email.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Familie Bakker',
                'adres' => 'Kerklaan 5, 4321 EF Dorp',
                'telefoon' => '0622334455',
                'email' => 'bakker@email.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Familie Visser',
                'adres' => 'Molenstraat 12, 3456 GH Stad',
                'telefoon' => '0611223344',
                'email' => 'visser@email.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Familie Smit',
                'adres' => 'Lindelaan 8, 6543 IJ Dorp',
                'telefoon' => '0699887766',
                'email' => 'smit@email.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->call(KlantenSeeder::class);

    }
}
