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
                'telefoon' => '0612345678',
                'email' => 'jan@example.com',


            ],
            [
                'naam' => 'Piet Pietersen',
                'telefoon' => '0687654321',
                'email' => 'piet@example.com',

            ],
            // Voeg hier meer klanten toe indien gewenst
        ]);
    }
}
