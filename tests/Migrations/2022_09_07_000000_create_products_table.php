<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->decimal('decimal_price_rub')
                ->nullable();
            $table->integer('integer_price_rub')
                ->nullable();
            $table->decimal('decimal_price')
                ->nullable();
            $table->integer('integer_price')
                ->nullable();
            $table->string('currency')
                ->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};