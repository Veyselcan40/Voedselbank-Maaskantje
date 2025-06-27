<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klanten', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('adres');
            $table->string('telefoon');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klanten');
    }
};
