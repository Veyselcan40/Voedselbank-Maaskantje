<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlantenTable extends Migration
{
    public function up()
    {
        Schema::create('klanten', function (Blueprint $table) {
            $table->id(); // maakt een auto-increment 'id' kolom
            $table->string('naam');
            // Voeg andere velden toe die je nodig hebt
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('klanten');
    }
}

