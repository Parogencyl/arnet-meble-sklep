<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->text('zamowienie');
            $table->string('laczna_kwota');
            $table->string('number_zamowienia')->unique();
            $table->string('rodzaj_platnosci');
            $table->string('status');
            $table->text('uwagi_do_zamowienia')->nullable();
            $table->string('potwierdzenie_sprzedazy');
            $table->integer('faktura_id')->nullable();
            $table->string('email');
            $table->string('name');
            $table->string('surname');
            $table->string('phone');
            $table->string('street');
            $table->string('local_number');
            $table->string('zip');
            $table->string('city');
            $table->integer('realizacja')->default(1);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
