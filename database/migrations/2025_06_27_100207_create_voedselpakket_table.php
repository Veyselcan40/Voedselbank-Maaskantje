<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoedselpakketTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('voedselpakket')) {
            Schema::create('voedselpakket', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('klant_id')->nullable(); // nullable zodat 0 of null mag
                $table->date('datum_samenstelling');
                $table->date('datum_uitgifte')->nullable();
                $table->timestamps();

                $table->foreign('klant_id')->references('id')->on('klanten')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('voedselpakket');
    }
}
