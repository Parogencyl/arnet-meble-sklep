<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->double('price');
            $table->double('price_delivery')->default(0);
            $table->string('product');
            $table->string('category');
            $table->string('delivery_number');
            $table->string('image')->nullable();
            $table->string('evaluation')->nullable();
            $table->text('comment')->nullable();
            $table->integer('opinion_id')->nullable();
            $table->string('street')->nullable();
            $table->string('local_number')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('bought_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_history');
    }
}
