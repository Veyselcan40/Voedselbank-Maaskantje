<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNummerToVoedselpakketTable extends Migration
{
    public function up()
    {
        Schema::table('voedselpakket', function (Blueprint $table) {
            $table->unsignedInteger('nummer')->after('id')->unique();
        });
    }

    public function down()
    {
        Schema::table('voedselpakket', function (Blueprint $table) {
            $table->dropColumn('nummer');
        });
    }
}
