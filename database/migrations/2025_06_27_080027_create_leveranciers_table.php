<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leveranciers', function (Blueprint $table) {
            $table->id();
            $table->string('Bedrijfsnaam');
            $table->string('Adres');
            $table->string('Contactpersoon');
            $table->string('Email');
            $table->string('Telefoon');
            $table->timestamp('EerstvolgendeLevering')->nullable();
            $table->string('Leverancierstype');
            $table->timestamps();
        });

        // Dummy data toevoegen (nu met Leverancierstype)
        \DB::table('leveranciers')->insert([
            [
                'Bedrijfsnaam' => 'VersGroothandel BV',
                'Adres' => 'Marktstraat 12, 1234 AB Maaskantje',
                'Contactpersoon' => 'Jan Jansen',
                'Email' => 'info@versgroothandel.nl',
                'Telefoon' => '0612345678',
                'EerstvolgendeLevering' => now()->addDays(2),
                'Leverancierstype' => 'groothandel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Bedrijfsnaam' => 'FruitExpress',
                'Adres' => 'Appellaan 5, 5678 CD Maaskantje',
                'Contactpersoon' => 'Piet Pietersen',
                'Email' => 'contact@fruitexpress.nl',
                'Telefoon' => '0687654321',
                'EerstvolgendeLevering' => now()->addDays(5),
                'Leverancierstype' => 'boeren',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Bedrijfsnaam' => 'Bakkerij de Boer',
                'Adres' => 'Bakkerstraat 1, 4321 EF Maaskantje',
                'Contactpersoon' => 'Klaas de Boer',
                'Email' => 'klaas@bakkerijdeboer.nl',
                'Telefoon' => '0622334455',
                'EerstvolgendeLevering' => null,
                'Leverancierstype' => 'supermarkt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leveranciers');
    }
};
