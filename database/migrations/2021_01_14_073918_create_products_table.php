<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('rodzaj');
            $table->string('kategoria');
            $table->string('nazwa')->unique();
            $table->double('cena');
            $table->double('stara_cena')->nullable();
            $table->double('koszt_wysylki');
            $table->double('ilosc_w_paczce')->default(1);
            $table->integer('ilosc_dostepnych');
            $table->string('zdjecie1');
            $table->string('zdjecie2')->nullable();
            $table->string('zdjecie3')->nullable();
            $table->string('zdjecie4')->nullable();
            $table->string('zdjecie5')->nullable();
            $table->double('szerokosc')->nullable();
            $table->double('wysokosc')->nullable();
            $table->double('glebokosc')->nullable();
            $table->string('waga')->nullable();
            $table->string('szuflada')->nullable();
            $table->string('front')->nullable();
            $table->string('korpus')->nullable();
            $table->string('blat')->nullable();
            $table->string('rozstaw')->nullable();
            $table->text('opis');
            $table->string('kolor')->nullable();
            $table->string('material')->nullable();
            $table->integer('ilosc_kupionych')->default(0);
            $table->boolean('w_sprzedazy')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
