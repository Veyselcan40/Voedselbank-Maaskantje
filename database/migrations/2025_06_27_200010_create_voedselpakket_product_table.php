<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('voedselpakket_product')) {
            Schema::create('voedselpakket_product', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('voedselpakket_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('aantal')->default(1);
                $table->timestamps();

                $table->foreign('voedselpakket_id')->references('id')->on('voedselpakket')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('producten')->onDelete('cascade');
                $table->unique(['voedselpakket_id', 'product_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('voedselpakket_product');
    }
};
