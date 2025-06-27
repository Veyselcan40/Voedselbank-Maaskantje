<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlantenTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('klanten')) {
            Schema::create('klanten', function (Blueprint $table) {
                $table->id();
                $table->string('naam');
                $table->string('adres')->default(''); // <-- default waarde zodat adres niet verplicht is
                $table->string('telefoon')->nullable();
                $table->string('email')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('klanten');
    }
}

