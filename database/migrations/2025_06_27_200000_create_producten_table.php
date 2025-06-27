<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Deze migratie maakt de 'producten' (voedsel) tabel aan voor voorraadbeheer.
        // Zie resources/views/voorraad.blade.php voor het gebruik in de applicatie.
        // Productcategorie tabel
        if (!Schema::hasTable('productcategorie')) {
            Schema::create('productcategorie', function (Blueprint $table) {
                $table->id();
                $table->string('categorienaam', 100);
            });
        }

        // Producten tabel
        if (!Schema::hasTable('producten')) {
            Schema::create('producten', function (Blueprint $table) {
                $table->id();
                $table->string('streepjescode', 20)->unique();
                $table->string('naam');
                $table->string('categorie');
                $table->integer('aantal')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('producten');
        Schema::dropIfExists('productcategorie');
    }
};

