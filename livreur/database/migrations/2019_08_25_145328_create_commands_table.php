<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('description');
            $table->integer('montant');
            $table->string('adresse');
            $table->integer('delivery_fee');
            $table->string('phone');
            $table->date('delivery_date'); 
            $table->integer('client_id');
            $table->integer('livreur_id');
            $table->integer('fee_id');
            $table->string('etat');
            $table->string('observation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commands');
    }
}
