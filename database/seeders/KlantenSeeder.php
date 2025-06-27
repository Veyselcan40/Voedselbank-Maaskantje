<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlantenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('klanten')->insert([
            [
                'naam' => 'Jan Jansen',
                'adres' => 'Straat 1, 1234 AB Plaats',
                'telefoon' => '0612345678',
                'email' => 'jan@example.com',
            ],
            [
                'naam' => 'Piet Pietersen',
                'adres' => 'Straat 2, 5678 CD Plaats',
                'telefoon' => '0687654321',
                'email' => 'piet@example.com',
            ],
            // Voeg hier meer klanten toe indien gewenst
        ]);
    }
}

