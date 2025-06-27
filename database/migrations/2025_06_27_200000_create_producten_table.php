<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('producten')) {
            Schema::create('producten', function (Blueprint $table) {
                $table->id();
                $table->string('streepjescode')->unique();
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
    }
};
